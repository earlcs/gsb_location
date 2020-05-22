<?php

namespace App\Form;

use App\Entity\Typeappart;
use App\Entity\Appartements;
use App\Entity\Arrondissement;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheAppartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->setMethod('POST')
            //->setAction('{{ path("listeAppart") }}')
            /*->add('typeappart', EntityType::class, [
                'class' => Typeappart::class,
                'choice_label' => 'typeAppart',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px',
                    'name' => 'typappart',
                ]
            ])*/
            ->add('typeappart', EntityType::class, [
                'class' => Typeappart::class,
                //'choice_label' => 'typeAppart',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('t')->orderBy('t.typeAppart', 'ASC');
                },
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px',
                    'name' => 'typappart',
                ]
            ])
            /*->add('arrondissement', EntityType::class, [
                'class' => Arrondissement::class,
                'choice_label' => 'arrondissDem',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px',
                    'name' => 'arrondissement',
                ]
            ])*/
            ->add('arrondissappart', EntityType::class, [
                'class' => Arrondissement::class,
                //'choice_label' => 'arrondissDem',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('ar')->orderBy('ar.arrondissDem', 'ASC');
                },
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px',
                    'name' => 'arrondissement',
                ]
            ])
            ->add('prixLoc', NumberType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'display:inline; margin-right:20px ',
                    'name' => 'prixLoc',
                ]
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-secondary my-2 my-sm-0',
                    
                ]
            ))
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
