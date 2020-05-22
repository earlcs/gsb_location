<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Entity\Typeappart;
use App\Form\DemandesType;
use App\Entity\Appartements;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandesController extends AbstractController
{
    

    /**
     * @Route("/demande/ajouter", name="ajoutDem")
     * 
     * création d'une nouvelle demande faite par un client
     */
    public function ajouterDemande(Request $request, ObjectManager $manager)
    {

        $demande = new Demandes();

        $form = $this->createForm(DemandesType::class, $demande);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $demande = $form->getData();

            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($demande);
            $manager->flush();

            $this->addFlash('success', 'La demande n°'.$demande->getNumDem().' a bien été créé.');

            return $this->redirectToRoute('listeDem');

        };
        dump($demande);

        return $this->render('demande/ajoutDem.html.twig', [
            'form_demande' => $form->createView(),
        ]);

    }

    /**
     * @Route("/demande/liste", name="listeDem")
     * 
     * affiche la liste de demandes de visite
     */
    public function getDemandes()
    {
        //$dem = $this->getDoctrine()->getRepository(Demandes::class)->findAll();
        $em = $this->getDoctrine()->getManager();
        $dem = "select c.NOM_CLI, c.PRENOM_CLI, d.NUM_CLI, d.NUM_DEM, d.TYPE_DEM, d.DATE_LIMITE from demandes d join clients c on d.NUM_CLI=c.NUM_CLI";
        $sql = $em->getConnection()->prepare($dem);
        $sql->execute();
        $rs = $sql->fetchAll();
        dump($rs);

        return $this->render('demande/listeDem.html.twig', array(
            'demandes' => $rs,
        ));
    }

    /**
     * @Route("/demande/modifier/{numDem}", name="modifierDem")
     */
    public function modifierDem(Request $request, Demandes $dem)
    {

        $form = $this->createForm(DemandesType::class, $dem);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            //$em->persist($appart);
            $em->flush();

            $this->addFlash('success', 'La demande n°'.$dem->getNumDem().' a bien été modifié.');
            return $this->redirectToRoute('listeDem');

        };
        dump($dem);

        return $this->render('demande/ajoutDem.html.twig', [
            'form_demande' => $form->createView(),
        ]);
    }

    /**
     * @Route("/demande/supprimer/{numDem}", name="supprimerDem")
     */
    public function supprimerDem($numDem){

        $em = $this->getDoctrine()->getManager();

        $dem = $em->getRepository(Demandes::class)->find($numDem);

        if (!$dem){
            return $this->redirectToRoute('listeDem');
        }

        $em->remove($dem);
        $em->flush();

        $this->addFlash('success', 'La demande n°'.$dem->getNumDem().' a bien été supprimé.');

        return $this->redirectToRoute('listeDem');
    }

}
