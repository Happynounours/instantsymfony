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



 #[Route(path:"/publication",name:"publication")]
    public function publication(): Response
    {
        return $this->render('publication.html.twig', []);
    }




<<<<<<< Updated upstream



    #[Route('/register', name: 'register')]
    public function register(Request $request, EntityManagerInterface $saved): Response
=======
    #[Route(path:"/register",name:"register")]
    public function register(Request $request,EntityManagerInterface $test)
>>>>>>> Stashed changes
    {

        $register = new Register();

        $registerForm = $this->createForm(RegisterType::class, $register);
        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()) {
            $image = $registerForm->get('imgprofil')->getData();
            $folder = $this->getParameter('profile.folder');
            $extension = $image->guessExtension();
            $filename = bin2hex(random_bytes(10)) . '.' . $extension;
            $image->move($folder, $filename);
            $register->setImgprofil($this->getParameter('profile.folder.public_path') . '/' . $filename);
            

            $saved->persist($register);
            $saved->flush();
        }

        return $this->render('register/index.html.twig', [
            'myform' => $registerForm->createView(),
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
