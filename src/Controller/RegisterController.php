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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegisterController extends AbstractController
{

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authUtils): Response
    {

        $error = $authUtils->getLastAuthenticationError();
        $username = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }

    #[Route('/register', name:'register')]
    public function register(EntityManagerInterface $emi, Request $request, UserPasswordHasherInterface $passwordHash): Response
    {
        $user =new User(); // instanciation
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->remove('description');
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $image = $userForm->get('imgProfil')->getData();
            $folder = $this->getParameter('profile.folder');
            $extension = $image->guessExtension();
            $filename = bin2hex(random_bytes(10)) . '.' . $extension;
            $image->move($folder, $filename);
            $user->setImgprofil($this->getParameter('profile.folder.public_path') . '/' . $filename);
            $user->setPassword($passwordHash->hashPassword($user, $user->getPassword()));
            $emi->persist($user);
            $emi->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $userForm->createView(),
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }
}
