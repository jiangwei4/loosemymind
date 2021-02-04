<?php

namespace App\Controller;

use App\Entity\EscapeGame;
use App\Form\NewEscapeGameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class NewEscapeGameController extends AbstractController
{
    /**
     * @Route("/new_escape_game", name="new_escape_game")
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $EscapeGame = new EscapeGame();
        $form= $this->createForm(NewEscapeGameType::class, $EscapeGame);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $EscapeGame = $form->getData();

            $image = $EscapeGame->getPhoto();
            $imagedata = file_get_contents($image);
             // alternatively specify an URL, if PHP settings allow
            $base64 = base64_encode($imagedata);

            $EscapeGame->setPhoto($base64);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($EscapeGame);
            $entityManager->flush();
            $logger->info('nouvel escapeGame !');
            $this->addFlash('notice','Nouveau escapeGame enregistré '.$EscapeGame->getNom());
           // $event = new UserRegisteredEvent($user);
           // $eventDispatcher->dispatch(UserRegisteredEvent::NAME,$event);
            return $this->redirectToRoute('home');
        }
        return $this->render('new_escape_game/index.html.twig', [
            'controller_name' => 'NewEscapeGameController',
            'form'=> $form->createView(),
        ]);
    }
}
