<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager){

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        /*dump($request);*/

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            $manager->flush();

            /*return new Response ('Utilisateur créé');*/
            $this->addFlash('success', 'Le compte de '.$user->getUsername().' a bien été créé.');
            return $this->redirectToRoute('security_login');
        }
        //dump($user);

        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/connexion", name="security_login")
     * 
     */
    public function login(){
        return $this->render('security/connexion.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){
        return $this->render('security/deconnexion.html.twig');
    }
}
