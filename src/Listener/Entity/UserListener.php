<?php

namespace App\Listener\Entity;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersistHandler(User $user, LifecycleEventArgs $event)
    {
        if ($user->getPlainPassword() !== null) {
            $user->setPassword(
                $this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword())
            );
        }

        if ( ! empty($user->getFirstName()) && ! empty($user->getLastName())) {
            $user->setUsername(
                $user->getFirstName() . ' ' . $user->getLastName()
            );
        }
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdateHandler(User $user, PreUpdateEventArgs $event)
    {
        if ($user->getPlainPassword() !== null) {
            $user->setPassword(
                $this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword())
            );

            $em   = $event->getEntityManager();
            $meta = $em->getClassMetadata(User::class);
            $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $user);
        }
    }
}