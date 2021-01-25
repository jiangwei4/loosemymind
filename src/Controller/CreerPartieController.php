<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EscapeGameRepository;
use App\Form\CreerPartieType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Partie;

class CreerPartieController extends AbstractController
{
    /**
     * @Route("/creerpartie", name="creerpartie")
     */
    public function index(EscapeGameRepository $escapeGameRepository): Response
    {
        $listeEscapeGame = $escapeGameRepository->findAll();
        return $this->render('creer_partie/index.html.twig', [
            'controller_name' => 'CreerPartieController',
            'listeEscapeGame' => $listeEscapeGame,
        ]);
    }

    /**
     * @Route("/creerpartie/this/{id}", name="creerpartie_this")
     */
    public function this(Request $request, EntityManagerInterface $entityManager,EscapeGameRepository $escapeGameRepository, int $id): Response
    {
        $user = $this->getUser();
        $escapeGame = $escapeGameRepository->find($id);
        $partie  = New Partie();
        $form = $this->createForm(CreerPartieType::class, $partie);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
           
            $partie = $form->getData();
            $partie->setUsers( $user);
            $partie->setEscapeGame($escapeGame);
            $partie->setPositionDansLaPartie(0);
            $partie->setFini(0);
            $formFin->get('users')->setData($this->getUser());

                
            dump($partie);die();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partie);
            $entityManager->flush();
            $this->addFlash('notice', 'Changement(s) effectué(s)!');

            //return $this->redirectToRoute('liste_escape_game_All');
            
        }

        return $this->render('creer_partie/creerpartie.html.twig', [
            'controller_name' => 'CreerPartieController',
            'form' => $form->createView(),
        ]);
    }
}
