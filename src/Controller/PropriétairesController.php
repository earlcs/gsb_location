<?php

namespace App\Controller;

use App\Entity\Proprietaires;
use App\Form\ProprietairesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropriétairesController extends AbstractController
{
    /**
     * @Route("/propriétaire/liste", name="listeproprio")
     * 
     * affihe la liste de propriétaires
     */
    public function getPropriétaires()
    {
        $propriétaires = $this->getDoctrine()->getRepository(Proprietaires::class)->findAll();
        //dump($propriétaires);
        return $this->render('propriétaire/listeProprio.html.twig', array(
            'propriétaires' => $propriétaires,
        ));
    }

    /**
     * @Route("/propriétaire/ajouter", name="ajoutproprio")
     * 
     * création d'un nouveau propriétaire
     */
    public function ajoutProprio(Request $request)
    {
        $proprio = new Proprietaires();

        $form = $this->createForm(ProprietairesType::class, $proprio);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $proprio = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($proprio);
            $em->flush();

            $this->addFlash('success', 'Le propriétaire '.$proprio->getNomPrenom().' a bien été créé.');

            return $this->redirectToRoute('listeproprio');

        };
        //dump($proprio);

        return $this->render('propriétaire/ajoutProprio.html.twig', [
            'form_proprio' => $form->createView(),
        ]);

    }

    /**
     * @Route("/propriétaire/{numeroprop}", name="id_propriétaire")
     * 
     * retourne les informations d'un propriétaire correspondant au 'numeroprop' indiqué dans l'URL
     */
    public function getIdProprio($numeroprop)
    {
        $proprio = $this->getDoctrine()->getRepository(Proprietaires::class)->find($numeroprop);
        //dump($proprio);
        return $this->render('propriétaire/showProprio.html.twig', [
            'numeroprop' => $proprio,
        ]);
    }

    /**
     * @Route("/propriétaire/modifier/{numeroprop}", name="modifierProprio")
     * 
     * modifie les informations du propriétaire choisi
     */
    public function modifierProprio(Request $request, Proprietaires $proprio)
    {

        $form = $this->createForm(ProprietairesType::class, $proprio);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            //$em->persist($appart);
            $em->flush();

            $this->addFlash('success', 'Le propriétaire '.$proprio->getNumeroprop().' a bien été modifié.');
            return $this->redirectToRoute('listeproprio');

        };
        //dump($proprio);

        return $this->render('propriétaire/ajoutProprio.html.twig', [
            'form_proprio' => $form->createView(),
        ]);
    }

    /**
     * @Route("/prorpiétaire/supprimer/{numeroprop}", name="supprimerProprio")
     * 
     * supprime un propriétaire
     */
    public function supprimerProprio($numeroprop){

        $em = $this->getDoctrine()->getManager();

        $proprio = $em->getRepository(Proprietaires::class)->find($numeroprop);

        if (!$proprio){
            return $this->redirectToRoute('listeproprio');
        }

        $em->remove($proprio);
        $em->flush();

        $this->addFlash('success', 'Le propriétaire '.$proprio->getNomPrenom().' a bien été supprimé.');

        return $this->redirectToRoute('listeproprio');
    }

}
