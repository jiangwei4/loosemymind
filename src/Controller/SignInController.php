<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignInType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SignInController extends AbstractController
{
    /**
     * @Route("/signin", name="signin")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {


        $user = new User();
        $form= $this->createForm(SignInType::class, $user);
        if($form->isSubmitted()){
            print_r($form);
            die();
        }
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('notice','Bonjour '+$user->getPrenom());
        }
        return $this->render('sign_in/index.html.twig', [
            'controller_name' => 'SignInController',
            'form'=> $form->createView(),
        ]);
    }
}
