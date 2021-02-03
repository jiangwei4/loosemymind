<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PartieRepository;

class ListePartieController extends AbstractController
{
    /**
     * @Route("/listepartie", name="listepartie")
     */
    public function index(PartieRepository $partieRepository): Response
    {
        $user = $this->getUser();
        $listePartie = $partieRepository->findBy(['user'=>$user]);
        return $this->render('liste_partie/index.html.twig', [
            'controller_name' => 'ListePartieController',
            'listePartie' => $listePartie,
        ]);
    }

    /**
     * @Route("/listepartieAll", name="listepartieAll")
     */
    public function indexall(PartieRepository $partieRepository): Response
    {
        
        $listePartie = $partieRepository->findAll();
        return $this->render('liste_partie_All/index.html.twig', [
            'controller_name' => 'ListePartieController',
            'listePartie' => $listePartie,
        ]);
    }
}
