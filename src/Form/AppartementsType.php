<?php

namespace App\Form;

use App\Entity\Locataires;
use App\Entity\Typeappart;
use App\Entity\Appartements;
use App\Entity\Proprietaires;
use App\Entity\Arrondissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AppartementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('typappart', EntityType::class, [
            //récupère et affiche les données de "typeAppart" de l'entité Typeappart
            'class' => Typeappart::class,
            'choice_label' => 'typeAppart',
            'attr' => [
                'class' => "form-control",
            ]
        ])
        ->add('prixLoc', NumberType::class, [
            'attr' => [
                'class' => "form-control"
            ]
        ])
        ->add('prixCharg', NumberType::class, [
            'attr' => [
                'class' => "form-control"
            ]
        ])
        ->add('rue', TextType::class, [
            'attr' => [
                'class' => "form-control",
                'placeholder' => "3 rue de la mairie"
            ]
        ])
        ->add('arrondissement', EntityType::class, [
            //récupère et affiche les données de "arrondissDem" de l'entité Arrondissement
            'class' => Arrondissement::class,
            'choice_label' => 'arrondissDem',
            'attr' => [
                'class' => "form-control"
            ],
        ])
        ->add('etage', IntegerType::class, [
            'attr' => [
                'class' => "form-control"
            ]
        ])
        ->add('ascenseur', ChoiceType::class,[
            'required' => true,
            'choices' => [
                'Oui' => '1',
                'Non' => '0',
            ],
            'attr' => [
                'class' => "form-control",
                'style' => "width:120px"
            ]
        ])
        ->add('preavis', ChoiceType::class,[
            'required' => true,
            'choices' => [
                'Oui' => '1',
                'Non' => '0',
            ],
            'attr' => [
                'class' => "form-control",
                'style' => "width:120px"
            ]
        ])
        ->add('dateLibre', DateType::class, [
            'widget' => 'single_text',
            'attr' => [
                'class' => "form-control",
            ]
        ])
        ->add('numeroprop', EntityType::class, array(
            'class' => Proprietaires::class,
            'choice_label' => 'NomPrenom',
            'expanded' => false,
            'multiple' => false,
            'attr' => [
                'class' => "form-control"
            ]
        ))
        ->add('numeroloc', EntityType::class, array(
            'class' => Locataires::class,
            'choice_label' => 'NomPrenomLoc',
            'expanded' => false,
            'multiple' => false,
            'attr' => [
                'class' => "form-control"
            ]
        ))
        ->add('save', SubmitType::class, array(
            'label' => 'Valider',
            'attr' => [
                'class' => 'btn btn-success',
                
            ]
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appartements::class,
        ]);
    }
}
