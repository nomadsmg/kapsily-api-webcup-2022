<?php

namespace App\Entity\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface SecurityInterface extends UserInterface
{
    public const GP_PROFILE = 'user.profile';
}
