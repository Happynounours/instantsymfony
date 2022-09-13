<?php

namespace App\Form;

use App\Entity\Register;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FormregisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class,[
                'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => 'Pseudo'

                ],
            ])
            ->add('email',TextType::class,[
                'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => 'Email'

                ],
            ] )
            ->add('password', PasswordType::class,[
                'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => 'Password'
                ]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Register::class,
        ]);
    }
}

