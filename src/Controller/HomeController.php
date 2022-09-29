<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\CategorieRepository;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

        $publication = $repo->findAll();


        return $this->render('home/homeallpublication.html.twig',[
            'publications' => $publication
        ]);
    }
    

    #[Route('/publication', name: 'publication')]
    public function publication(Request $request, EntityManagerInterface $test, CategorieRepository $repo): Response
    {
        // $categorie = $repo->findBy([], ['name' => 'DESC']);
        // $categorie = $repo->findNameOfCat();
        $categorie = $repo->findAll();
        $user = $this->getUser();

        // dd($categorie);


        $newpublication = new Publication();
        $formPublication = $this->createForm(PublicationType::class, $newpublication);
        $formPublication->add('image', FileType::class)
                        ->add('title', TextType::class,[
                            'label' => false,
                            'attr' => [
                                'class' => 'titlepublication',     
                                'placeholder' => 'Titre',
                                'label' => '',
                            ],
                        ])

                        ->add('description', TextareaType::class,[
                            'label' => false,
                            'attr' => [
                                'class' => 'descriptionpublication',     
                                'placeholder' => 'Description',
                            ],
                        ])

                        ->add('categorie', ChoiceType::class, [
                            // 'mapped' => false,
                            'choices' => $categorie
                            ]);
            $formPublication->handleRequest($request);

         if($formPublication->isSubmitted() && $formPublication->isValid()) {
            $image = $formPublication->get('image')->getData();
            $folder = $this->getParameter('publication.folder');
            $extension = $image->guessExtension();
            $filename = bin2hex(random_bytes(10)) . '.' . $extension;
            $image->move($folder, $filename);
            $newpublication->setImage($this->getParameter('publication.folder.public_path') . '/' . $filename);
            $newpublication->setDate(new \DateTime());
            $newpublication->setUser($user);
            // dd($formPublication);

            $test->persist($newpublication);
            $test->flush();
            return $this->redirectToRoute('home');
        };

        return $this->render('publication/publication.html.twig', [
            'form' => $formPublication->createView()
        ]);
    
}

#[Route('/settings', name: 'settings')]


    public function settings()
    {
        return $this->render('home/settings.html.twig',
    );
    }

}
