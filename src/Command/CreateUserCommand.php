<?php

namespace App\Command;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $em;

    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();
        $this->em = $em;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('firstname', InputArgument::REQUIRED, 'Firstname required')
            ->addArgument('lastname', InputArgument::REQUIRED, 'Lastname required')
            ->addArgument('email', InputArgument::REQUIRED, 'Email required')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io         = new SymfonyStyle($input, $output);
        $firstname  = $input->getArgument('firstname');
        $lastname   = $input->getArgument('lastname');
        $email      = $input->getArgument('email');

        if ($firstname) {
            $io->note(sprintf('You passed a firstname: %s', $firstname));
        }
        if ($lastname) {
            $io->note(sprintf('You passed a lastname: %s', $lastname));
        }
        if ($email) {
            $io->note(sprintf('You passed an email: %s', $email));
        }
        $admin = $this->em->getRepository(Admin::class)->findOneBy(['email' => $email]);
        if (!$admin) {
            $admin = new Admin();
        }
        
        $admin
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setRoles(['ROLE_ADMIN']);

        $admin->setPassword($this->encoder->encodePassword($admin, 'password'));

        $this->em->persist($admin);

        $this->em->flush();

        $io->success('User inserted: ' . $firstname . ' ' . $lastname);

        return 0;
    }
}
