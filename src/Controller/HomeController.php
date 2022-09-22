<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\CategorieRepository;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/homeallpublication', name: 'homeallpublication')]
    public function homeallpublication(PublicationRepository $repo): Response
    {

        $publication = $repo->findBy([], ['date' => 'DESC']);


        return $this->render('home/homeallpublication.html.twig',[
            'publications' => $publication
        ]);
    }
    

    #[Route('/publication', name: 'publication')]
    public function publication(Request $request, EntityManagerInterface $test)
    {
        $newpublication = new Publication();
        $formPublication = $this->createForm(PublicationType::class, $newpublication);
            $formPublication->handleRequest($request);


         if ($formPublication->isSubmitted() && $formPublication->isValid()) {
            $image = $formPublication->get('image')->getData();
            $folder = $this->getParameter('publication.folder');
            $extension = $image->guessExtension();
            $filename = bin2hex(random_bytes(10)) . '.' . $extension;
            $image->move($folder, $filename);
            $newpublication->setImage($this->getParameter('publication.folder.public_path') . '/' . $filename);
            $newpublication->setDate(new \DateTime());
            $test->persist($newpublication);
            $test->flush();
            return $this->redirectToRoute('home');
        };

        return $this->render('publication.html.twig', [
            'formPublication' => $formPublication->createView(),
        ]);
    

}
}
