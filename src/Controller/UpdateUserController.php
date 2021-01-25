<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use App\Entity\User;
use App\Form\UpdateUserType;
use Doctrine\ORM\EntityManagerInterface;

class UpdateUserController extends AbstractController
{
    /**
     * @Route("/update_user", name="update_user")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);
        //dump($form);die();
        if($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();
            $this->addFlash('notice','les changements ont bien été éffectués');
            return $this->redirectToRoute('home');
        }
        return $this->render('update_user/index.html.twig', [
            'controller_name' => 'UpdateUserController',
            'form'=> $form->createView(),
        ]);
    }
}
