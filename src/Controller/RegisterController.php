<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $notificationSuccess = null;
        $notificationError = null;

        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $searchEmail = $this->em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if(!$searchEmail)
            {
                $password = $hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($password);
                $this->em->persist($user);
                $this->em->flush();
                $notificationSuccess = 'Inscription terminée.';
                return $this->redirectToRoute('app_login');
            } else {
                $notificationError = 'L\'email renseigné existe déjà';
            }
        }


        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notificationError' => $notificationError,
            'notificationSuccess' => $notificationSuccess
        ]);
    }
}
