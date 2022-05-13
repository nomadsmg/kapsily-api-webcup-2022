<?php

namespace App\Action\Security;

use App\Action\ApiAbstractAction;
use App\Entity\Security\SecurityInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/api/me', methods: Request::METHOD_GET, name: 'api_user_profile')]
class UserProfileAction extends ApiAbstractAction
{
    public function __construct(private TokenStorageInterface $tokenStorage, private SerializerInterface $serializer)
    {
    }

    public function __invoke(): JsonResponse
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        return $this->sendJsonSuccess([
            'user' => json_decode($this->serializer->serialize($user, 'json', [
                'groups' => SecurityInterface::GP_PROFILE
            ]), true)
        ]);
    }
}
