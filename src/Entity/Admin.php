<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Admin extends User
{
    /**
     * @ORM\PrePersist()
     */
    public function initRoles()
    {
        $this->setRoles(['ROLE_ADMIN']);
    }
}
