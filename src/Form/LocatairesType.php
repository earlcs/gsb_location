<?php

namespace App\Form;

use App\Entity\Locataires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LocatairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLoc', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => "text-transform: uppercase",
                    'placeholder' => "NOM"
                ]
            ])
            ->add('prenomLoc', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => "text-transform: capitalize",
                    'placeholder' => "Prénom"
                ]
            ])
            ->add('datenaiss', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('telLoc', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex : 0123456789',
                ]
            ])
            ->add('rib', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('banque', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('rueBanque', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Ex : 3 rue de la mairie",
                ]
            ])
            ->add('codevilleBanque', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "75000 Paris"
                ]
            ])
            ->add('telBanque', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex : 0123456789',
                ]
            ])
            /*->add('save', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => "btn btn-success",
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Locataires::class,
        ]);
    }
}
