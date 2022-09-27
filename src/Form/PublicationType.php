<?php

namespace App\Form;

use App\Entity\Publication;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('image',FileType::class, [
            'attr' => [
                'class' => 'publicationimage'
            ],
            'mapped' => false,
             'constraints' => [
            new Image([
                'mimeTypesMessage' => 'Veuillez soumettre une image',
                'maxSize' => '20M',
                'maxSizeMessage' => 'L\'image est trop grande, sa taille est de {{ limit }} {{ suffix }}'
            ])
        ]])
            ->add('title', TypeTextType::class, [
               'attr' => [
                'placeholder' => 'Titre',
                'class' => 'publicationtitle',
            
            ],
               'help' => 'Ce champ est obligatoire'
            ])

            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Description',
                    'class' => 'publicationdescription',
                ],
                'help' => 'Ce champ est obligatoire'
             ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
