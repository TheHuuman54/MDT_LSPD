<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\JudiciaryCase;
use App\Form\JudiciaryCaseType;
use App\Form\SearchType;
use App\Repository\JudiciaryCaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/judiciary/case')]
class JudiciaryCaseController extends AbstractController
{
    #[Route('/', name: 'app_judiciary_case_index', methods: ['GET'])]
    public function index(Request $request ,JudiciaryCaseRepository $judiciaryCaseRepository): Response
    {
        $search = new Search();
        $search->page = $request->get('page',1);
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $judiciaryCases = $judiciaryCaseRepository->findWidthSearch($search);

        return $this->render('judiciary_case/index.html.twig', [
            'judiciary_cases' => $judiciaryCases,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_judiciary_case_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JudiciaryCaseRepository $judiciaryCaseRepository): Response
    {
        $judiciaryCase = new JudiciaryCase();
        $form = $this->createForm(JudiciaryCaseType::class, $judiciaryCase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $judiciaryCaseRepository->save($judiciaryCase, true);

            return $this->redirectToRoute('app_judiciary_case_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('judiciary_case/new.html.twig', [
            'judiciary_case' => $judiciaryCase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_judiciary_case_show', methods: ['GET'])]
    public function show(JudiciaryCase $judiciaryCase): Response
    {
        return $this->render('judiciary_case/show.html.twig', [
            'judiciary_case' => $judiciaryCase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_judiciary_case_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JudiciaryCase $judiciaryCase, JudiciaryCaseRepository $judiciaryCaseRepository): Response
    {
        $form = $this->createForm(JudiciaryCaseType::class, $judiciaryCase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $judiciaryCaseRepository->save($judiciaryCase, true);

            return $this->redirectToRoute('app_judiciary_case_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('judiciary_case/edit.html.twig', [
            'judiciary_case' => $judiciaryCase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_judiciary_case_delete', methods: ['POST'])]
    public function delete(Request $request, JudiciaryCase $judiciaryCase, JudiciaryCaseRepository $judiciaryCaseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$judiciaryCase->getId(), $request->request->get('_token'))) {
            $judiciaryCaseRepository->remove($judiciaryCase, true);
        }

        return $this->redirectToRoute('app_judiciary_case_index', [], Response::HTTP_SEE_OTHER);
    }
}
