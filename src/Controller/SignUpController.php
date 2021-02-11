<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Event\UserRegisteredEvent;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class SignUpController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, /*EventDispatcherInterface $eventDispatcher, UserRepository $userRepository,*/ LoggerInterface $logger): Response
    {
        $user = new User();
        $form= $this->createForm(SignUpType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $image = $user->getPhoto();
            
            if($image !== null){
                $imagedata = file_get_contents($image);
             // alternatively specify an URL, if PHP settings allow
                $base64 = base64_encode($imagedata);

                $user->setPhoto($base64);
            }
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $logger->info('nouvel utilisateur !');
            $this->addFlash('notice','Nouveau utilisateur enregistré '.$user->getPrenom());


            $message = (new \Swift_Message('Nouveau contact'))
                ->setFrom('contact.loosemymind@gmail.com')
                ->setTo($user->getMail())
                ->setSubject('Bienvenu sur Loose My Mind')
                ->setBody('Bonjour '.$user->getPrenom().' votre compte a bien été crée')
                //->attach(Swift_Attachment::fromPath('/path/to/a/file.zip'))
                ;
                
            $mailer->send($message);



           // $event = new UserRegisteredEvent($user);
           // $eventDispatcher->dispatch(UserRegisteredEvent::NAME,$event);
            return $this->redirectToRoute('home');
        }
        return $this->render('sign_up/index.html.twig', [
            'controller_name' => 'SignUpController',
            'form'=> $form->createView(),
        ]);
    }
}
