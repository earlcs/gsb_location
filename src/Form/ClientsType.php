<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nomCli', TextType::class, [
                    'attr' => [
                        'class' => "form-control",
                        'placeholder' => "NOM"
                    ]
                ])
                ->add('prenomCli', TextType::class, [
                    'attr' => [
                        'class' => "form-control",
                        'placeholder' => "Prénom"
                    ]
                ])
                ->add('adresseCli', TextType::class, [
                    'attr' => [
                        'class' => "form-control",
                        'placeholder' => "Ex : 3 rue de la mairie"
                    ]
                ])
                ->add('codevilleCli', TextType::class, [
                    'attr' => [
                        'class' => "form-control",
                        'placeholder' => "Ex : 75000 Paris"
                    ]
                ])
                ->add('telCli', TextType::class, [
                    'required' => false,
                    'attr' => [
                        'class' => "form-control",
                        'placeholder' => "Ex : 0123456789"
                    ]
                ])
                ->add('username', TextType::class, [
                    'attr' => [
                        'class' => "form-control"
                    ]
                ])
                ->add('password', PasswordType::class, [
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
            'data_class' => Clients::class,
        ]);
    }
}
