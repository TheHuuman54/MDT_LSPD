<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Arrestation;
use App\Entity\Pictures;
use App\Form\ArrestationType;
use App\Form\SearchType;
use App\Repository\ArrestationRepository;
use App\Repository\PicturesRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/arrestation')]
class ArrestationController extends AbstractController
{
    #[Route('/', name: 'app_arrestation_index', methods: ['GET'])]
    public function index(Request $request, ArrestationRepository $arrestationRepository): Response
    {
        $search = new Search();
        $search->page = $request->get('page',1);
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $arrestations = $arrestationRepository->findWidthSearch($search);
        return $this->render('arrestation/index.html.twig', [
            'arrestations' => $arrestations,
            'form' => $form->createView()

        ]);
    }

    #[Route('/new', name: 'app_arrestation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArrestationRepository $arrestationRepository, PictureService $pictureService): Response
    {
        $arrestation = new Arrestation();
        $form = $this->createForm(ArrestationType::class, $arrestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('justicePicture')->getData();

            foreach($pictures as $picture)
            {
                // we define destination directory
                $folder = 'justicePicture';

                //we call add service
                $file = $pictureService->add($picture,$folder, 300,300);

                $img = new Pictures();
                $img->setFilename($file);
                $arrestation->addJusticePicture($img);
            }

            $arrestationRepository->save($arrestation, true);

            return $this->redirectToRoute('app_arrestation_show',array('id' => $arrestation->getID()));
        }

        return $this->renderForm('arrestation/new.html.twig', [
            'arrestation' => $arrestation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_arrestation_show', methods: ['GET'])]
    public function show(Arrestation $arrestation): Response
    {
        return $this->render('arrestation/show.html.twig', [
            'arrestation' => $arrestation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_arrestation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Arrestation $arrestation, ArrestationRepository $arrestationRepository, PictureService $pictureService): Response
    {
        $form = $this->createForm(ArrestationType::class, $arrestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $form->get('justicePicture')->getData();

            foreach($pictures as $picture)
            {
                // we define destination directory
                $folder = 'justicePicture';

                //we call add service
                $file = $pictureService->add($picture,$folder, 300,300);

                $img = new Pictures();
                $img->setFilename($file);
                $arrestation->addJusticePicture($img);
            }
            $arrestationRepository->save($arrestation, true);

            return $this->redirectToRoute('app_arrestation_show',array('id' => $arrestation->getID()));
        }

        return $this->renderForm('arrestation/edit.html.twig', [
            'arrestation' => $arrestation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_arrestation_delete', methods: ['POST'])]
    public function delete(PicturesRepository $picture,Request $request, Arrestation $arrestation, ArrestationRepository $arrestationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$arrestation->getId(), $request->request->get('_token'))) {
            $arrestationRepository->remove($arrestation, true);
        }

        return $this->redirectToRoute('app_arrestation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/picture/{id}', name: 'app_justicePicture_delete', methods: ['DELETE'])]
    public function deleteJusticePicture(Pictures $img, EntityManagerInterface $em, Request $request, PictureService $pictureService): JsonResponse
    {
        //On récupère le contenu de la requête

        $data = json_decode($request->getContent(), true);
        
        if($this->isCsrfTokenValid('delete' . $img->getId(), $data['_token']))
        {
            //le token est valide
            // on récupère le nom de l'image

            $name = $img->getFilename();
            if($pictureService->delete($name, 'justicePicture', 300, 300))
            {
                $em->remove($img);
                $em->flush();

                return new JsonResponse(['success' => true ], 200);
            }

            return new JsonResponse(['error' => 'Erreur lors de la suppression'], 400);
        }

        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
