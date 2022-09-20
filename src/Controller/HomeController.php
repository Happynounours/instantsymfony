<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(CategorieRepository $repo): Response
    {

        $categorie = $repo->findAll();


        return $this->render('home/home.html.twig',[
            'categories' => $categorie
        ]);
    }
}
