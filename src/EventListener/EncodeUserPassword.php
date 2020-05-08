<?php
namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EncodeUserPassword
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->encodePassword($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->encodePassword($args);
    }

    private function encodePassword(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof UserInterface) {
            $password = !empty($entity->getPassword()) ? $entity->getPassword() : 'password';
            $hash = $this->encoder->encodePassword($entity, $password);

            $entity->setPassword($hash);
        }
    }
}