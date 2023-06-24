<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Arrestation;
use App\Entity\Civil;
use App\Entity\Pictures;
use App\Form\CivilType;
use App\Form\SearchType;
use App\Repository\ArrestationRepository;
use App\Repository\CivilRepository;
use App\Repository\PicturesRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/civil')]
class CivilController extends AbstractController
{
    #[Route('/', name: 'app_civil_index', methods: ['GET'])]
    public function index(CivilRepository $civilRepository, Request $request): Response
    {
        $search = new Search();
        $search->page = $request->get('page',1);
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $civils = $civilRepository->findWidthSearch($search);

        return $this->render('civil/index.html.twig', [
            'civils' => $civils,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_civil_new', methods: ['GET', 'POST'])]
    public function new(PictureService $pictureService, Request $request, CivilRepository $civilRepository): Response
    {
        $civil = new Civil();
        $form = $this->createForm(CivilType::class, $civil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('documents')->getData();
            foreach($pictures as $picture)
            {
                // we define destination directory
                $folder = 'documents';

                //we call add service
                $file = $pictureService->add($picture,$folder, 300,300);

                $img = new Pictures();
                $img->setFilename($file);
                $civil->addDocument($img);
            }
            $civilRepository->save($civil, true);

            return $this->redirectToRoute('app_civil_show', array('id' => $civil->getId()));
        }

        return $this->renderForm('civil/new.html.twig', [
            'civil' => $civil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_civil_show', methods: ['GET'])]
    public function show(Civil $civil): Response
    {
        return $this->render('civil/show.html.twig', [
            'civil' => $civil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_civil_edit', methods: ['GET', 'POST'])]
    public function edit(PictureService $pictureService, Request $request, Civil $civil, CivilRepository $civilRepository): Response
    {
        $form = $this->createForm(CivilType::class, $civil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('documents')->getData();

            foreach($pictures as $picture) {
                // we define destination directory
                $folder = 'documents';

                //we call add service
                $file = $pictureService->add($picture, $folder, 300, 300);

                $img = new Pictures();
                $img->setFilename($file);
                $civil->addDocument($img);
            }
            $civilRepository->save($civil, true);

            return $this->redirectToRoute('app_civil_show', array('id' => $civil->getId()));
        }

        return $this->renderForm('civil/edit.html.twig', [
            'civil' => $civil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_civil_delete', methods: ['POST'])]
    public function delete(PicturesRepository $picture, Request $request, ArrestationRepository $arrestation, Civil $civil, EntityManagerInterface $em, CivilRepository $civilRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$civil->getId(), $request->request->get('_token'))) {
            $civilRepository->remove($civil, true);
        }

        return $this->redirectToRoute('app_civil_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/picture/{id}', name: 'app_documents_delete', methods: ['DELETE'])]
    public function deleteJusticePicture(Pictures $img, EntityManagerInterface $em, Request $request, PictureService $pictureService): JsonResponse
    {
        //On récupère le contenu de la requête

        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete' . $img->getId(), $data['_token']))
        {
            //le token est valide
            // on récupère le nom de l'image

            $name = $img->getFilename();
            if($pictureService->delete($name, 'documents', 300, 300))
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
