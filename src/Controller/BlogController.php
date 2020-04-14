<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     * 
     * affiche la page d'accueil
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }


    /**
     * @Route("/test", name="accueil")
     */
    /*public function accueil()
    {
        return $this->render('vues/v_connexion.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }*/

}
