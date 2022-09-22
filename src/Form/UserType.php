<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('pseudo')
            ->add('imgProfil',FileType::class, ['mapped' => false, 'constraints' => [
                new Image([
                    'mimeTypesMessage' => 'Veuillez soumettre une image',
                    'maxSize' => '20M',
                    'maxSizeMessage' => 'L\'image est trop grande, sa taille est de {{ limit }} {{ suffix }}'
                ])
            ]])
            ->add('description');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
