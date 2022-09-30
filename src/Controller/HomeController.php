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

    #[Route('/onecat/{id}', name: 'onecat')]
    public function onecat(CategorieRepository $repo, PublicationRepository $prepo, $id): Response
    {
            $onecat = $prepo->findBy(['categorie' => $id]);
        return $this->render('oneCategorie/index.html.twig',[
            'onecat' => $onecat
        ]);
    }

    #[Route('/one_publication/{id}', name:'one_publication')]
    public function one_publication(PublicationRepository $prepo, $id) : Response
    {

    
            $one_publication = $prepo->findBy(['id' => $id]);

            return $this->render('home/onepublication.html.twig', [
            'one_publication' => $one_publication
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
    public function publication(Request $request, EntityManagerInterface $test, CategorieRepository $repo): Response
    {
        // $categorie = $repo->findBy([], ['name' => 'DESC']);
        // $categorie = $repo->findNameOfCat();
        $categorie = $repo->findAll();
        $user = $this->getUser();

        // dd($categorie);


        $newpublication = new Publication();
        $formPublication = $this->createForm(PublicationType::class, $newpublication);
        $formPublication->add('image', FileType::class,[
            'label' => false,
            'attr' => [
                'class' => 'inputfile',     
                'placeholder' => false,
            ],
        ])
                        ->add('title', TextType::class,[
                            'label' => false,
                            'attr' => [
                                'class' => 'inputtext',     
                                'placeholder' => 'Titre',
                            ],
                        ])

                        ->add('description', TextareaType::class,[
                            'label' => false,
                            'attr' => [
                                'class' => 'inputtextarea',     
                                'placeholder' => 'Description',
                            ],
                        ])

                        ->add('categorie', ChoiceType::class, [
                            'attr' => [
                                'class' => 'selectinput',     
                            ],
                            'choices' => $categorie,
                            'label' => false,
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
