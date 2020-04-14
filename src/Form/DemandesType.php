<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Demandes;
use App\Entity\Typeappart;
use App\Entity\Appartements;
use App\Entity\Arrondissement;
use App\Controller\DemandesController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DemandesType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeDem', EntityType::class, [
                //récupère et affiche les données de la colonne "typeAppart" de l'entité Typeappart
                'class' => Typeappart::class,
                'choice_label' => 'typeAppart',
                'attr' => [
                    'class' => "form-control",
                ]
            ])
            ->add('dateLimite', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => "form-control",
                ]
            ])
            //->add('clients')
            ->add('numCli', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'NomPrenomCli',
                'attr' => [
                    'class' => "form-control",
                ]
            ])
            ->add('arrondissDem', EntityType::class, [
                'class' => Arrondissement::class,
                'choice_label' => 'arrondissDem',
                'attr' => [
                    'class' => "form-control",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demandes::class,
        ]);
    }
}
