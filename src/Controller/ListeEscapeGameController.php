<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EscapeGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditEscapeGameType;
use Symfony\Component\HttpFoundation\Request;

class ListeEscapeGameController extends AbstractController
{
    /**
     * @Route("/listeescapegameall", name="listeescapegameall")
     */
    public function indexAll(EscapeGameRepository $escapeGameRepository): Response
    {
        $listeEscapeGame = $escapeGameRepository->findAll();
        return $this->render('liste_escape_game_All/index.html.twig', [
            'controller_name' => 'ListeEscapeGameController',
            'listeEscapeGame' => $listeEscapeGame,
        ]);
    }

    /**
     * @Route("/listeescapegame", name="listeescapegame")
     */
    public function index(EscapeGameRepository $escapeGameRepository): Response
    {
        $listeEscapeGame = $escapeGameRepository->findAll();
        return $this->render('liste_escape_game/index.html.twig', [
            'controller_name' => 'ListeEscapeGameController',
            'listeEscapeGame' => $listeEscapeGame,
        ]);
    }
    /**
     * @Route("/listeescapegameall/edit/{id}", name="listeescapegameall_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager,EscapeGameRepository $escapeGameRepository, int $id): Response
    {
        $escapeGame = $escapeGameRepository->find($id);
        $form = $this->createForm(EditEscapeGameType::class, $escapeGame);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($escapeGame);
            $entityManager->flush();
            $this->addFlash('notice', 'Changement(s) effectué(s)!');

            return $this->redirectToRoute('liste_escape_game_All');
        }

        return $this->render('liste_escape_game_All/editEscapeGame.html.twig', [
            'controller_name' => 'ListeEscapeGameController',
            'form' => $form->createView(),
        ]);
    }
     /**
     * @Route("/listeescapegameall/remove/{id}", name="listeescapegameall_remove")
     */
    public function remove(EscapeGame $escapeGame, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $entityManager->remove($escapeGame);
        $entityManager->flush();
        $this->addFlash('notice', 'escapeGame supprimé');
        $event = new MovieRemovedEvent($escapeGame);
        $eventDispatcher->dispatch(MovieRemovedEvent::NAME,$event);
        return $this->redirectToRoute('liste_escape_game_All');
    }
}
