<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:createAdmin';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager= $entityManager;
        $this->encoder = $encoder;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Ajouter un Admin')
            ->addArgument('nom', InputArgument::REQUIRED, 'nom description')
            ->addArgument('prenom', InputArgument::REQUIRED, 'prenom description')
            ->addArgument('email', InputArgument::REQUIRED, 'email description')
            ->addArgument('motdepasse', InputArgument::REQUIRED, 'password description')
            ->addArgument('telephone', InputArgument::REQUIRED, 'telephone description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $firstname = $input->getArgument('prenom');
        $lastname = $input->getArgument('nom');
        $password = $input->getArgument('motdepasse');
        $telephone = $input->getArgument('telephone');
        if (null === $email || null === $firstname || null === $lastname ||null === $password || null === $telephone) {
            $io->error('Vous n\'avez pas rentré d\'email et/ou de firstname et/ou lastname et/ou de mot de passe');
            return;
        }
        $io->note(sprintf('Create a Admin User for email: %s, prenom: %s, nom: %s, password: %s, telephone: %s', $email,$firstname,$lastname,$password,$telephone));
        $user = new User();
        $user->setMail($email);
        $user->setPrenom($firstname);
        $user->setNom($lastname);
        $passwordEncoded = $this->encoder->encodePassword($user, $password);
        $user->setPassword($passwordEncoded);
        $user->setTelephone($telephone);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $io->success(sprintf('You\'ve created an Admin-user with email: %s and password %s', $email, $password));
        return 1;
    }
}
