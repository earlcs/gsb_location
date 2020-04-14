<?php

namespace App\Form;

use App\Entity\Typeappart;
use App\Entity\Appartements;
use App\Entity\Arrondissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RechercheAppartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->setMethod('GET', 'POST')
            ->add('typappart', EntityType::class, [
                'class' => Typeappart::class,
                'choice_label' => 'typeAppart',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px',
                ]
            ])
            ->add('arrondissement', EntityType::class, [
                'class' => Arrondissement::class,
                'choice_label' => 'arrondissDem',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px',
                ]
            ])
            ->add('prixLoc', NumberType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px ',
                ]
            ])
            //->add('prixCharg')
            //->add('rue')
            //->add('arrondissappart')
            //->add('etage')
            //->add('ascenseur')
            //->add('preavis')
            //->add('dateLibre')
            //->add('proprietaire')
            //->add('locataire')
            //->add('typappart')
            
            //->add('numeroprop')
            //->add('numeroloc')
            //->add('numCli')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appartements::class,
            //'method' => 'GET', 'POST',
        ]);
    }
}
