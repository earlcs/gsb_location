<?php

namespace App\Controller;

use App\Entity\Locataires;
use App\Entity\Typeappart;
use App\Entity\Appartements;
use App\Entity\Proprietaires;
use App\Form\AjoutAppartType;

use App\Form\ModifAppartType;
use App\Entity\Arrondissement;
use App\Form\AppartementsType;
use App\Form\RechercheAppartType;
use App\Controller\AppartementsController;
use App\Repository\AppartementsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/*use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;*/

class AppartementsController extends AbstractController
{

    /**
     * @Route("/appartement/ajouter", name="ajoutAppart")
     * Method({"GET", "POST"})
     * 
     * création/ajout d'un appartement
     */
    public function ajoutAppart(Request $request, ObjectManager $manager)
    {

        $appart = new Appartements();

        $form = $this->createForm(AppartementsType::class, $appart);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($appart);
            $manager->flush();

            $this->addFlash('success', 'L\'appartement '.$appart->getNumappart().' a bien été créé.');
            return $this->redirectToRoute('listeAppart');

        };

        return $this->render('appartement/ajoutAppart.html.twig', [
            'form_appart' => $form->createView(),
        ]);
    }

    /**
     * @Route("/appartement/liste", name="listeAppart")
     * 
     * 1 - affiche la liste des appartements
     * 2 - retourne les appartements en fonction des éléments sélectionnés dans le formulaire de recherche
     */
    public function getAppart(/*$numappart,*/ Request $request)
    {

        $entity = new Appartements();
        $em = $this->getDoctrine()->getManager();
        //$id = $em->getRepository(Appartements::class)->find($numappart);

        $form = $this->createForm(RechercheAppartType::class, $entity);
        $form->handleRequest($request);
        //$em = $this->getDoctrine()->getManager();
        //$numappart = $em->getRepository(Appartements::class)->find($numappart);
        
            
        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();  //récupère les informations du formulaire de recherche
                
            $appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $data->getTypeappart(), 'prixLoc' => $data->getPrixLoc(), 'arrondissement' => $data->getArrondissappart()]);
            $req = 'SELECT * FROM appartements a WHERE a.typappart IN (SELECT typeAppart FROM typeappart t WHERE t.typeAppart="'.$data->getTypeappart().'")'.
                   ' AND a.arrondissement IN (SELECT arrondissDem FROM arrondissement ar WHERE ar.arrondissDem='.$data->getArrondissappart().') AND a.prixLoc>='.$data->getPrixLoc().';';

            //$req = 'select * from appartements where typappart="'.$data->getTypeappart().'" and arrondissement='.$data->getArrondissappart().' and prixLoc>='.$data->getPrixLoc().';';

            $sql = $em->getConnection()->prepare($req);
            $sql->execute();

            $rs = $sql->fetchAll();
                
        }
        else{
            $appart = $em->getRepository(Appartements::class)->findAll();
        }

        /*return $this->render('appartement/rechercheAppart.html.twig', [
            'appartements' => $entity,
            'form_recherche' => $form->createView(),
        ]);*/


        //$appart = $this->getDoctrine()->getRepository(Appartements::class)->findAll();

        return $this->render('appartement/listeAppart.html.twig', array(
            //'appartement' => $id,
            'appartements' => $appart,
            'form_recherche' => $form->createView(),

        ));
        
    }

    /**
     * @Route("/appartement/{numappart}/propriétaire/{numeroprop}", name="detailproprio")
     * 
     * retourne les informations du propriétaire d'un appartement choisi
     */
    public function getDetailProprio($numappart, $numeroprop)
    {
        
        $em = $this->getDoctrine()->getManager();
        $appart = $em->getRepository(Appartements::class)->find($numappart);
        $proprio = $em->getRepository(Proprietaires::class)->find($numeroprop);
        $req = 'select p.NUMEROPROP,NOM,PRENOM,ADRESSE,CODE_VILLE,TEL from proprietaires p join appartements a on p.NUMEROPROP=a.NUMEROPROP where NUMAPPART='.$numappart.';';

        $sql = $em->getConnection()->prepare($req);
        $sql->execute();

        $rs = $sql->fetchAll();

        return $this->render('appartement/showProprio.html.twig', [
            'appartement' => $appart,
            'propriétaire' => $proprio,
        ]);

    }

    /**
     * @Route("/appartement/{numappart}/locataire/{numeroloc}", name="detailloc")
     * 
     * retourne les informations du locataire d'un appartement choisi
     */
    public function getDetailLoc($numappart, $numeroloc)
    {
        
        $em = $this->getDoctrine()->getManager();
        $appart = $em->getRepository(Appartements::class)->find($numappart);
        $loc = $em->getRepository(Locataires::class)->find($numeroloc);
        $req = 'select l.NUMEROLOC, NOM_LOC, PRENOM_LOC, DATENAISS, TEL_LOC, R_I_B, BANQUE, RUE_BANQUE, CODEVILLE_BANQUE, TEL_BANQUE FROM locataires l join appartements a on l.NUMEROLOC=a.NUMEROLOC where NUMAPPART='.$numappart.';';

        $sql = $em->getConnection()->prepare($req);
        $sql->execute();

        $rs = $sql->fetchAll();

        return $this->render('appartement/showLoc.html.twig', [
            'appartement' => $appart,
            'locataire' => $loc,
        ]);

    }

    /**
     * @Route("/appartement/modifier/{numappart}", name="modifierAppart")
     * 
     * modifie l'appartement sélectionné
     */
    public function modifierAppart(Request $request, Appartements $appart)
    {

        $form = $this->createForm(ModifAppartType::class, $appart);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            //$em->persist($appart);
            $em->flush();

            $this->addFlash('success', 'L\'appartement '.$appart->getNumappart().' a bien été modifié.');
            return $this->redirectToRoute('listeAppart');

        };

        return $this->render('appartement/modifAppart.html.twig', [
            'form_appart' => $form->createView(),
        ]);
    }

    /**
     * @Route("/appartement/supprimer/{numappart}", name="supprimerAppart")
     * 
     * supprime l'appartement sélectionnné
     */
    public function supprimerAppart($numappart){

        $em = $this->getDoctrine()->getManager();

        $appart = $em->getRepository(Appartements::class)->find($numappart);

        if (!$appart){
            return $this->redirectToRoute('listeAppart');
        }

        $em->remove($appart);
        $em->flush();

        $this->addFlash('success', 'L\'appartement '.$appart->getNumappart().' a bien été supprimé.');

        return $this->redirectToRoute('listeAppart');
    }

    /**
     * @Route("/appartement/recherche", name="rechercheAppart")
     * 
     * retourne les appartements en fonction des éléments sélectionnés dans le formulaire de recherche
     * 
     */
    /*public function rechercheAppart(Request $request)
    {
        $appart = new Appartements();

        $form = $this->createForm(RechercheAppartType::class, $appart);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
            
        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();  //récupère les informations du formulaire de recherche
                
            $appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $data->getTypeappart(), 'prixLoc' => $data->getPrixLoc(), 'arrondissement' => $data->getArrondissappart()]);
            $req = 'SELECT * FROM appartements a WHERE a.typappart IN (SELECT typeAppart FROM typeappart t WHERE t.typeAppart="'.$data->getTypeappart().'")'.' AND a.arrondissement IN (SELECT arrondissDem FROM arrondissement ar WHERE ar.arrondissDem='.$data->getArrondissappart().') AND a.prixLoc>='.$data->getPrixLoc().';';
            //$req = 'select * from appartements where typappart="'.$data->getTypeappart().'" and arrondissement='.$data->getArrondissappart().' and prixLoc>='.$data->getPrixLoc().';';
            $sql = $em->getConnection()->prepare($req);
            $sql->execute();

            $rs = $sql->fetchAll();
                
        }
        //else{
        //    $appart = $em->getRepository(Appartements::class)->findAll();
        //}

        return $this->render('appartement/rechercheAppart.html.twig', [
            'appartements' => $entity,
            'form_recherche' => $form->createView(),
        ]);
    }*/


}
