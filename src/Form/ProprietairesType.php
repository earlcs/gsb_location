<?php

namespace App\Form;

use App\Entity\Proprietaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProprietairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => "text-transform: uppercase",
                    'placeholder' => "NOM"
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => "text-transform: capitalize",
                    'placeholder' => "Prénom"
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Ex : 3 rue de la mairie"
                ]
            ])
            ->add('codeVille', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Ex : 75000 Paris"
                ]
            ])
            ->add('tel', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Ex : 0123456789"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proprietaires::class,
        ]);
    }
}
