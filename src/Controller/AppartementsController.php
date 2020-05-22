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
        //dump($appart);
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
    /*public function getAppart(Request $request)
    {
    
        $entity = new Appartements();
        $em = $this->getDoctrine()->getManager();
        //$id = $em->getRepository(Appartements::class)->find($numappart);
        $appart = $em->getRepository(Appartements::class)->findAll();
    
        $form = $this->createForm(RechercheAppartType::class, $entity);
        $form->handleRequest($request);
        //$em = $this->getDoctrine()->getManager();
        //$numappart = $em->getRepository(Appartements::class)->find($numappart);
            
                
        if($form->isSubmitted() && $form->isValid() && $request->isMethod("post")){*/
    
            /*$niveau = $request->get('niveau');
            $appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $niveau]);*/
            
            /*$data = $form->getData();  //récupère les informations du formulaire de recherche
            //$type = $form->get('typappart');
            //$arrondiss = $form->get('arrondissement');
            //$prix = $form->get('prixLoc');
            
            $appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $data->getTypeappart(), 'arrondissement' => $data->getArrondissappart(), 'prixLoc' => $data->getPrixLoc()]);
            //$appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $type, 'arrondissement' => $arrondiss, 'prixLoc' => $prix]);
            $req = 'SELECT * FROM appartements a WHERE a.typappart IN (SELECT typeAppart FROM typeappart t WHERE t.typeAppart="'.$data->getTypeappart().'")'.
                   ' AND a.arrondissement IN (SELECT arrondissDem FROM arrondissement ar WHERE ar.arrondissDem='.$data->getArrondissappart().') AND a.prixLoc>='.$data->getPrixLoc().';';*/
            /*$req = 'SELECT * FROM appartements a WHERE a.typappart IN (SELECT typeAppart FROM typeappart t WHERE t.typeAppart="'.$type.'")'.
                   ' AND a.arrondissement IN (SELECT arrondissDem FROM arrondissement ar WHERE ar.arrondissDem='.$arrondiss.') AND a.prixLoc>='.$prix.';';*/
            /*$req = 'select * from appartements where typappart="'.$type.'" and arrondissement='.$arrondiss.' and prixLoc>='.$prix.';';*/

            //$req = 'select * from appartements where TYPAPPART="'.$data->getTypeappart().'" and ARRONDISSEMENT='.$data->getArrondissappart().' and PRIX_LOC>='.$data->getPrixLoc().';';
            //$req = 'select * from appartements a join typeappart t on a.TYPAPPART=t.TYPE_APPART and join arrondissement ar on a.ARRONDISSEMENT=ar.ARRONDISS_DEM where t.TYPE_APPART="'.$data->getTypeappart().'" and ar.ARRONDISS_DEM='.$data->getArrondissappart().' and PRIX_LOC>='.$data->getPrixLoc().';';

            /*$sql = $em->getConnection()->prepare($req);
            $sql->execute();
    
            $rs = $sql->fetchAll();
                    
        }*/
        /*else{
            $appart = $em->getRepository(Appartements::class)->findAll();
        }*/
    
        /*return $this->render('appartement/rechercheAppart.html.twig', [
            'appartements' => $entity,
            'form_recherche' => $form->createView(),
        ]);*/
    
    
        //$appart = $this->getDoctrine()->getRepository(Appartements::class)->findAll();
    
        /*return $this->render('appartement/listeAppart.html.twig', array(
            //'appartement' => $id,
            'appartements' => $appart,
            'form_recherche' => $form->createView(),

        ));
            
    }*/

    /**
     * @Route("/appartement/liste", name="listeAppart")
     */
    public function getAppart(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        //$typappart = $em->getRepository(Typeappart::class)->findAll();
        //$appart = $em->getRepository(Appartements::class)->findAll();
        $req = "select * from appartements";
        $typeappart = $em->getRepository(Typeappart::class)->findAll();
        $arrondissement = $em->getRepository(Arrondissement::class)->findAll();

        if($request->isMethod("post")){
            
            $type = $request->get('typeappart');
            $arrondiss = $request->get('arrondissement');
            $prixMin = $request->get('prixLocMin');
            $prixMax = $request->get('prixLocMax');
            //$typappart = $em->getRepository(Typeappart::class)->findBy(['typeAppart' => $type]);
            //$arrondissement = $em->getRepository(Arrondissement::class)->findBy(['arrondissement' => $arrondiss]);
            //$prixLoc = $em->getRepository(Appartements::class)->findBy(['pricLoc' => $prix]);
            if($type !== null && $arrondiss == null && $prixMin == null && $prixMax == null){
                //$appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $type]);
                $req = "select * from appartements where TYPAPPART='".$type."';";
            }elseif($arrondiss !== null && $type == null && $prixMin == null && $prixMax == null){
                //$appart = $em->getRepository(Appartements::class)->findBy(['arrondissement' => $arrondiss]);
                $req = "select * from appartements where ARRONDISSEMENT=".$arrondiss.";";
            }elseif($prixMin !== null && $prixMax !== null && $type == null && $arrondiss == null){
                //$appart = $em->getRepository(Appartements::class)->findBy(['prixLoc' => $prix]);
                $req = "select * from appartements where PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax." order by PRIX_LOC;";
            }elseif($type !== null && $arrondiss !== null && $prixMin == null && $prixMax == null){
                //$appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $type, 'arrondissement' => $arrondiss]);
                $req = "select * from appartements where TYPAPPART='".$type."' and ARRONDISSEMENT=".$arrondiss.";";
            }elseif($type !== null && $prixMin !== null && $prixMax !== null && $arrondiss == null){
                //$appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $type, 'prixLoc' => $prix]);
                $req = "select * from appartements where TYPAPPART='".$type."' and PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax.";";
            }elseif($arrondiss !== null && $prixMin !== null && $prixMax !== null && $type == null){
                //$appart = $em->getRepository(Appartements::class)->findBy(['prixLoc' => $prix, 'arrondissement' => $arrondiss]);
                $req = "select * from appartements where PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax." and ARRONDISSEMENT=".$arrondiss.";";
            }else{
                //$appart = $em->getRepository(Appartements::class)->findBy(['typappart' => $type, 'arrondissement' => $arrondiss, 'prixLoc' => $prix]);
                $req = "select * from appartements where TYPAPPART='".$type."' and ARRONDISSEMENT=".$arrondiss." and PRIX_LOC BETWEEN ".$prixMin." AND ".$prixMax.";";
            }
            /*dump($appart);
            $sql = $em->getConnection()->prepare($req);
            $sql->execute();
    
            $rs = $sql->fetchAll();*/
        }
        
        $sql = $em->getConnection()->prepare($req);
        $sql->execute();
        $rs = $sql->fetchAll();
        //dump($rs);
        //$em->persist($appart);
        //$em->flush();

        return $this->render('appartement/listeAppart.html.twig', array(
            //'appartement' => $id,
            //'appartements' => $appart,
            //'form_recherche' => $form->createView(),
            'types' => $typeappart,
            'arrondissements' => $arrondissement,
            //'appartements' => $appart,
            'appartements' => $rs,

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
