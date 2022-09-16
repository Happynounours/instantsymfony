<?php

namespace App\Form;

use App\Entity\Register;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('email')
            ->add('password')
            ->add('imgprofil',FileType::class, ['mapped' => false, 'constraints' => [
                new Image([
                    'mimeTypesMessage' => 'Veuillez soumettre une image',
                    'maxSize' => '20M',
                    'maxSizeMessage' => 'L\'image est trop grande, sa taille est de {{ limit }} {{ suffix }}'
                ])
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Register::class,
        ]);
    }
}
