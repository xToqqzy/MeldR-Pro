<?php

namespace App\Command;

use App\Entity\AppUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

#[AsCommand(
    name: 'app:user:create'
)]
class UserCreateCommand extends Command
{
    private EntityManagerInterface $em;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED)
            ->addArgument('givenName', InputArgument::REQUIRED)
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $passwordGenerated = false;
        $password = $input->getArgument('password');
        if (empty($password)) {
            $password = md5(time());
            $passwordGenerated = true;
        }

        $user = new AppUser();
        $user->setUsername($input->getArgument('username'));
        $user->setGivenName($input->getArgument('givenName'));
        $user->setEmail($input->getArgument('email'));
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('Gebruiker aangemaakt');
        if ($passwordGenerated === true) {
            $output->writeln('Wachtwoord: ' . $password);
        }

        return Command::SUCCESS;
    }
}
