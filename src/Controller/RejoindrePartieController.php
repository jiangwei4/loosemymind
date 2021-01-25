<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RejoindrePartieType;
use App\Entity\Partie;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EscapeGameRepository;

class RejoindrePartieController extends AbstractController
{
    /**
     * @Route("/rejoindre_partie", name="rejoindre_partie")
     */
    public function index(Request $request, EscapeGameRepository $escapeGameRepository): Response
    {

        //$partie =  $escapeGameRepository->findAll();
        $partie = New Partie();
        $form= $this->createForm(RejoindrePartieType::class, $partie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /*$user = $form->getData();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();*/
            $logger->info('nouvel utilisateur !');
            $this->addFlash('notice','Nouveau utilisateur enregistré '.$user->getPrenom());
           // $event = new UserRegisteredEvent($user);
           // $eventDispatcher->dispatch(UserRegisteredEvent::NAME,$event);
            return $this->redirectToRoute('home');
        }
        return $this->render('rejoindre_partie/index.html.twig', [
            'controller_name' => 'RejoindrePartieController',
            'form'=> $form->createView(),
        ]);
    }
}
