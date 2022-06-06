<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 23/05/2022
 * Time: 23:50
 */

namespace App\EventListener;


use App\Entity\Task;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TaskPersistListener
{
    protected TokenStorageInterface $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof Task) {
            $user = $this->tokenStorage->getToken()->getUser();

            $entity->setUser($user);
        }
    }
}