<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Register;
use App\Form\FormregisterType;
use App\Form\PublicationType;
use App\Repository\CategorieRepository;
use App\Repository\PublicationRepository;
use App\Repository\RegisterRepository;
use Doctrine\ORM\EntityManager;
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
    public function index(CategorieRepository $repo)
    {
        $categorie = $repo->findAll();


        return $this->render('home.html.twig',[
            'categories' => $categorie
        ]);
        
    }


    #[
        Route(path: '/pubread',name:"pubread")
    ]
    public function pubread(PublicationRepository $repo)
    {
        $pubread = $repo->findAll();


        return $this->render('pubread.html.twig',[
            'pubreads' => $pubread
        ]);
        
    }


    #[Route(path:"/publication",name:"publication")]
    public function publication(Request $request,EntityManagerInterface $test)
    {
        $newpublication = new Publication();

        $publicationform = $this->createForm(PublicationType::class, $newpublication);
        $publicationform->handleRequest($request);

        if ($publicationform->isSubmitted() && $publicationform->isValid()){
            $test->persist($newpublication);
            $test->flush();
            
        }

        return $this->render('publication.html.twig',[
            'publicationformulaire' => $publicationform->createView()
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
