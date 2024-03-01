<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class resetPassword extends Command
{
    private $entityManager;
    private $userPasswordHasher;

    public function construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->$entityManager=$entityManager;
        $this->$userPasswordHasher=$userPasswordHasher;

        parent::construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:user:reset')
            ->setDescription('Reset a user account')
            ->setHelp('This command allows you to reset a user account.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('Introduce el email del que quieres cambiar la contraseña:');

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $io->error('Usuario no encontrado.');
            return Command::FAILURE;
        }

        
            $newPassword = $io->ask('Introduzca la nueva contraseña:');
            
            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $newPassword)
            );

        $this->entityManager->flush();

        $io->success('La contraseña ha sido actualizada.');

        return Command::SUCCESS;
    }
}