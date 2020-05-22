<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientsController extends AbstractController
{
    /**
     * @Route("/client/liste", name="clients")
     */
    public function getClients()
    {
        $clients = $this->getDoctrine()->getRepository(Clients::class)->findAll();
        //dump($clients);
        return $this->render('client/listeClient.html.twig', array(
            'clients' => $clients,
        ));
    }

    /**
     * @Route("/client/ajouter", name="ajoutclient")
     * 
     * création d'un nouveau client
     */
    public function ajouterClient(Request $request, ObjectManager $manager)
    {

        $client = new Clients();

        $form = $this->createForm(ClientsType::class, $client);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $client = $form->getData();

            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($client);
            $manager->flush();

            //$this->addFlash('success', 'Le client '.$client->getNomPrenomCli().' a bien été créé.');

            //return $this->redirectToRoute('ajoutclient');
            if(!$this->login()){
                $this->addFlash('success', 'Le client '.$client->getNomPrenomCli().' a bien été créé.');
                return $this->redirectToRoute('security_login');
            } else{
                return $this->redirectToRoute('clients');
            }

        };
        //dump($client);

        return $this->render('client/ajoutClient.html.twig', [
            'form_client' => $form->createView(),
        ]);

    }

    /**
     * @Route("/connexion", name="security_login")
     * 
     * page de connexion
     */
    public function login(){
        return $this->render('security/connexion.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     * 
     * déconnexion
     */
    public function logout(){
        return $this->render('security/deconnexion.html.twig');
    }

    /**
     * @Route("/client/modifier/{numCli}", name="modifierCli")
     * 
     * modifier les informations d'un client
     */
    public function modifierClient(Request $request, Clients $client)
    {

        $form = $this->createForm(ClientsType::class, $client);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            //$em->persist($appart);
            $em->flush();

            $this->addFlash('success', 'Les informations du client '.$client->getNomPrenomCli().' ont bien été modifié.');
            return $this->redirectToRoute('clients');

        };
        //dump($client);

        return $this->render('client/ajoutClient.html.twig', [
            'form_client' => $form->createView(),
        ]);
    }

    /**
     * @Route("/client/supprimer/{numCli}", name="supprimerCli")
     * 
     * supprime le client sélectionné
     */
    public function supprimerClient($numCli){

        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository(Clients::class)->find($numCli);

        if (!$client){
            return $this->redirectToRoute('listeLoc');
        }

        $em->remove($client);
        $em->flush();

        $this->addFlash('success', 'Le client '.$client->getNomPrenomCli().' a bien été supprimé.');

        return $this->redirectToRoute('clients');
    }

}
