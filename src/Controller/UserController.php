<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'user')]
    public function user(User $user): Response
    {

        $currentUser = $this->getUser();
        if($currentUser === $user) {
            return $this->redirectToRoute('user_current');
        }

        return $this->render('user/otherprofil.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user', name: 'user_current')]
    public function index(Request $request, EntityManagerInterface $emi): Response
    {

        $user = $this->getUser();
        $userform = $this->createForm(UserType::class, $user);
        $userform->remove('password');
        $userform->handleRequest($request);

        if($userform->isSubmitted() && $userform->isValid()) {
            $emi->flush();
            $this->addFlash(
               'success',
               'Profil modifié'
            );
        }

        return $this->render('user/index.html.twig', [
            'form' => $userform->createView(),
            'user' => $user
        ]);
    }
}
