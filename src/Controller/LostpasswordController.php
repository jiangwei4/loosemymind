<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Userpasswordchange;
use App\Form\LostpasswordType;
use App\Form\Lostpassword2Type;
use App\Form\UserpasswordchangeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Repository\UserpasswordchangeRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LostpasswordController extends AbstractController
{
    /**
     * @Route("/lostpassword", name="lostpassword")
     */
    public function index(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(LostpasswordType::class, $user);
        
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $pass = rand(100000, 999999);
            $listeUser = $userRepository->findBy(['mail'=>$form->getData()->getMail()]);
            if(sizeof($listeUser)>0){

                $mail= $listeUser[0]->getMail();
                
                $userpasswordchange = new Userpasswordchange();
                $userpasswordchange->setCode($pass);
                $userpasswordchange->setMail($mail);
                $userpasswordchange->setDate(new \DateTime("now"));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($userpasswordchange);
                $entityManager->flush();

                $message = (new \Swift_Message('Nouveau contact'))
                ->setFrom('contact.loosemymind@gmail.com')
                ->setTo($mail)
                ->setSubject('Changement de mot de passe sur Loose My Mind')
                ->setBody('Bonjour '.$user->getPrenom().' vous avez demandé à changer votre mot de passe, si oui merci de rentrer le code ci dessous :'.$pass)
                //->attach(Swift_Attachment::fromPath('/path/to/a/file.zip'))
                ;
                
                $mailer->send($message);

                return $this->redirectToRoute('lostpassword2', array(
                    'id' => $userpasswordchange->getId(),
                ));
            }
        }
        return $this->render('lostpassword/index.html.twig', [
            'controller_name' => 'LostpasswordController',
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/lostpassword2/{id}", name="lostpassword2")
     */
    public function index2($id, Request $request, UserpasswordchangeRepository $userpasswordchangerepository, UserRepository $userRepository): Response
    {
        //$userpasswordchange = $userpasswordchangerepository->findBy(['id'=>$id])[0];
        $userpasswordchange = new Userpasswordchange();
        $form = $this->createForm(Lostpassword2Type::class, $userpasswordchange);
        $form->handleRequest($request);
        if($form->isSubmitted()/* && $form->isValid()*/){
            $listeUserpasswordchange = $userpasswordchangerepository->findBy(['code'=>$form->getData()->getCode(), 'id'=>$id]);
            if(sizeof($listeUserpasswordchange)>0) {
                //if date ok {
                   
                    $listeUser = $userRepository->findBy(['mail'=>$listeUserpasswordchange[0]->getMail()]);
 
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($listeUserpasswordchange[0]);
                    $entityManager->flush();

                    if(sizeof($listeUser)>0){
                        return $this->redirectToRoute('userchangepassword', array(
                            'id' => $listeUser[0]->getId(),
                        ));
                    }
                
                //}  else {

                    //dump('jeton expiré');die();
                //}
            } else {
                dump('code faux');die();
            }
        }

        return $this->render('lostpassword/index2.html.twig', [
            'controller_name' => 'LostpasswordController',
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/userchangepassword/{id}", name="userchangepassword")
     */
    public function index3($id, Request $request, UserRepository $userRepository, \Swift_Mailer $mailer, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user =  $userRepository->findBy(['id'=>$id])[0];
        //dump($user);die();
        $form = $this->createForm(UserpasswordchangeType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //$logger->info('nouvel utilisateur !');
            //$this->addFlash('notice','Nouveau utilisateur enregistré '.$user->getPrenom());


            $message = (new \Swift_Message('Nouveau contact'))
                ->setFrom('contact.loosemymind@gmail.com')
                ->setTo($user->getMail())
                ->setSubject('Changement de mot de passe sur Loose My Mind')
                ->setBody('Bonjour '.$user->getPrenom().' votre changement de mot de passe a bien été éffectué')
                //->attach(Swift_Attachment::fromPath('/path/to/a/file.zip'))
                ;
                
            $mailer->send($message);

            return $this->redirectToRoute('home');
        }

        return $this->render('lostpassword/index3.html.twig', [
            'controller_name' => 'LostpasswordController',
            'form'=> $form->createView(),
        ]);

    }
}
