<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'createAdmin';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $firstname = $input->getArgument('prenom');
        $lastname = $input->getArgument('nom');
        $password = $input->getArgument('motdepasse');
        if (null === $email || null === $firstname || null === $lastname ||null === $password) {
            $io->error('Vous n\'avez pas rentré d\'email et/ou de firstname et/ou lastname et/ou de mot de passe');
            return;
        }
        $io->note(sprintf('Create a Master for email: %s, prenom: %s, nom: %s, password: %s', $email,$firstname,$lastname,$password));
        $user = new Master();
        $user->setEmail($email);
        $user->setFirstname($prenom);
        $user->setLastname($nom);
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $io->success(sprintf('You\'ve created an Admin-user with email: %s and firstname %s  and lastname %s', $email, $firstname,$lastname ));
    }
}
