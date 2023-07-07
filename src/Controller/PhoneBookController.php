<?php

namespace App\Controller;

use App\Classe\Search;
use App\Form\SearchType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneBookController extends AbstractController
{
    #[Route('/phone/book', name: 'app_phone_book')]
    public function index(Request $request,UserRepository $ur): Response
    {
        $search = new Search();
        $search->page = $request->get('page',1);
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $agents = $ur->findWidthSearch($search);
        return $this->render('phone_book/index.html.twig', [
            'agents'=> $agents,
            'form' => $form->createView(),
        ]);
    }
}
