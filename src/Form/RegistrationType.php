<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('mdp', PasswordType::class, [
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('confirm_mdp', PasswordType::class, [
                'attr' => [
                    'class' => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
