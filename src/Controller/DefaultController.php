<?php

namespace App\Controller;

use App\Entity\Register;
use App\Form\FormregisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[
        Route(path: '/',name:"home")
    ]
    public function index()
    {
        return $this->render('home.html.twig',[
        ]);
    }


    #[Route(path:"/register",name:"register")]
    public function register(Request $request,EntityManagerInterface $test)
    {
        $userregister = new Register();

        $registerform = $this->createForm(FormregisterType::class, $userregister);
        $registerform->handleRequest($request);

        if ($registerform->isSubmitted() && $registerform->isValid()){
            $test->persist($userregister);
            $test->flush();
            dd($userregister);
        }

        return $this->render('register.html.twig',[
            'myform' => $registerform->createView()
        ]);
    }




    
    #[Route(path:"/login",name:"login")]
    public function login(Request $request,EntityManagerInterface $test)
    {
        $userregister = new Register();

        $registerform = $this->createForm(FormregisterType::class, $userregister);
        $registerform->handleRequest($request);

        if ($registerform->isSubmitted() && $registerform->isValid()){
            $test->persist($userregister);
            $test->flush();
            dd($userregister);
        }

        return $this->render('login.html.twig',[
            'myform' => $registerform->createView()
        ]);
    }
}
