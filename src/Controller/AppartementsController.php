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
use Doctrine\ORM\EntityRepository;
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
        //dump($appart);
        return $this->render('appartement/ajoutAppart.html.twig', [
            'form_appart' => $form->createView(),
        ]);
    }

    /**
     * @Route("/appartement/liste", name="listeAppart")
     */
    public function getAppart(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $req = "select * from appartements";
        $typeappart = $em->getRepository(Typeappart::class)->findAll();
        $arrondissement = $em->getRepository(Arrondissement::class)->findAll();

        if($request->isMethod("post")){
            
            $type = $request->get('typeappart');
            $arrondiss = $request->get('arrondissement');
            $prixMin = $request->get('prixLocMin');
            $prixMax = $request->get('prixLocMax');
            if($type !== null && $arrondiss == null && $prixMin == null && $prixMax == null){
                $req = "select * from appartements where TYPAPPART='".$type."';";
            }elseif($arrondiss !== null && $type == null && $prixMin == null && $prixMax == null){
                $req = "select * from appartements where ARRONDISSEMENT=".$arrondiss.";";
            }elseif($prixMin !== null && $prixMax !== null && $type == null && $arrondiss == null){
                $req = "select * from appartements where PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax." order by PRIX_LOC;";
            }elseif($type !== null && $arrondiss !== null && $prixMin == null && $prixMax == null){
                $req = "select * from appartements where TYPAPPART='".$type."' and ARRONDISSEMENT=".$arrondiss.";";
            }elseif($type !== null && $prixMin !== null && $prixMax !== null && $arrondiss == null){
                $req = "select * from appartements where TYPAPPART='".$type."' and PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax.";";
            }elseif($arrondiss !== null && $prixMin !== null && $prixMax !== null && $type == null){
                $req = "select * from appartements where PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax." and ARRONDISSEMENT=".$arrondiss.";";
            }else{
                $req = "select * from appartements where TYPAPPART='".$type."' and ARRONDISSEMENT=".$arrondiss." and PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax.";";
            }
        }
        
        $sql = $em->getConnection()->prepare($req);
        $sql->execute();
        $rs = $sql->fetchAll();
        //dump($rs);

        return $this->render('appartement/listeAppart.html.twig', array(
            'types' => $typeappart,
            'arrondissements' => $arrondissement,
            'appartements' => $rs,

        ));
    }
    
    /**
     * @Route("/appartement/cotisation/propriétaire/{numeroprop}", name="detailcotisation")
     * 
     * retourne les cotisations de chaque appartement pour chaque propriétaire
     */
    public function getDetailCotisation($numeroprop)
    {
        
        $em = $this->getDoctrine()->getManager();
        $req = 'select NUMAPPART, PRIX_LOC, (PRIX_LOC*0.07) as APPART_COTISATION, SUM(PRIX_LOC*0.07) as TOTAL_COTISATION from appartements WHERE NUMEROPROP='.$numeroprop.';';
        $req2= 'select SUM(PRIX_LOC*0.07) as TOTAL_COTISATION from appartements where NUMEROPROP='.$numeroprop.';';
        
        $sql = $em->getConnection()->prepare($req);
        $sql->execute();

        $sql2 = $em->getConnection()->prepare($req2);
        $sql2->execute();

        $rs = $sql->fetchAll();
        $rs2 = $sql2->fetchAll();
        //dump($rs);

        return $this->render('propriétaire/showCotisation.html.twig', [
            'appartements' => $rs,
            'cotisations' => $rs2,
        ]);

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
        //dump($rs);

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
        //dump($rs);

        return $this->render('appartement/showLoc.html.twig', [
            'appartement' => $appart,
            'locataire' => $loc,
        ]);

    }
    
    /**
     * @Route("/appartement/cotisation", name="cotisation")
     * 
     * retourne le montant total des cotisations pour chaque propriétaire
     */
    public function getCotisation()
    {
        
        $em = $this->getDoctrine()->getManager();
        $req = 'select distinct a.NUMEROPROP, p.NOM, p.PRENOM, p.ADRESSE, p.CODE_VILLE, p.TEL, SUM(PRIX_LOC*0.07) as TOTAL_COTISATION 
        from appartements a join proprietaires p on a.NUMEROPROP=p.NUMEROPROP group by a.NUMEROPROP';

        $sql = $em->getConnection()->prepare($req);
        $sql->execute();

        $rs = $sql->fetchAll();
        //dump($rs);

        return $this->render('propriétaire/cotisation.html.twig', [
            'propriétaires' => $rs,
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
