<?php

namespace App\Action\UserCapsule;

use App\Entity\Capsule\UserCapsule\UserCapsule;
use App\Manager\UserCapsule\UserCapsuleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HandleAddCapsuleAction extends AbstractController
{
    public function __invoke(Request $request, UserCapsuleManager $manager): UserCapsule
    {
        return $manager->addFromRequest($request);
    }
}
