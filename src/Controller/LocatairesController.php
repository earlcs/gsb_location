<?php

namespace App\Controller;

use App\Entity\Locataires;
use App\Form\LocatairesType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocatairesController extends AbstractController
{
    /**
     * @Route("/locataire/liste", name="listeLoc")
     * 
     * affiche la liste des locataires
     */
    public function getLocataires()
    {
        $locataires = $this->getDoctrine()->getRepository(Locataires::class)->findAll();
        
        return $this->render('locataire/listeLoc.html.twig', array(
            'locataires' => $locataires,
        ));
    }

    /**
     * @Route("/locataire/ajouter", name="ajoutLoc")
     * 
     * création d'un nouveau locataire
     */
    public function ajouterLocataire(Request $request, ObjectManager $manager)
    {

        $locataire = new Locataires();

        $form = $this->createForm(LocatairesType::class, $locataire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $locataire = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($locataire);
            $em->flush();

            $this->addFlash('success', 'Le locataire '.$locataire->getNomPrenomLoc().' a bien été créé.');

            return $this->redirectToRoute('listeLoc');

        };

        return $this->render('locataire/ajoutLoc.html.twig', [
            'form_locataire' => $form->createView(),
        ]);

    }

    /**
     * @Route("/locataire/modifier/{numeroloc}", name="modifierLoc")
     * 
     * modifier les informations d'un locataire sélectionné
     */
    public function modifierAppart(Request $request, Locataires $loc)
    {

        $form = $this->createForm(LocatairesType::class, $loc);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            //$em->persist($appart);
            $em->flush();

            $this->addFlash('success', 'Le locataire '.$loc->getNumeroloc().' a bien été modifié.');
            return $this->redirectToRoute('listeLoc');

        };

        return $this->render('locataire/ajoutLoc.html.twig', [
            'form_locataire' => $form->createView(),
        ]);
    }

    /**
     * @Route("/locataire/supprimer/{numeroloc}", name="supprimerLoc")
     * 
     * supprimer un locataire 
     */
    public function supprimerLoc($numeroloc){

        $em = $this->getDoctrine()->getManager();

        $loc = $em->getRepository(Locataires::class)->find($numeroloc);

        if (!$loc){
            return $this->redirectToRoute('listeLoc');
        }

        $em->remove($loc);
        $em->flush();

        $this->addFlash('success', 'Le locataire '.$loc->getNomPrenomLoc().' a bien été supprimé.');

        return $this->redirectToRoute('listeLoc');
    }

}
