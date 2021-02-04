<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PartieRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PartieRepository $partieRepository): Response
    {
        $user = $this->getUser();
        $listePartie = $partieRepository->findBy(['user'=>$user]);
        //dump($listePartie); die();
        $tableauDeBord = [sizeof($listePartie),5,4];
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tableauDeBord' => $tableauDeBord,
        ]);
    }
}
