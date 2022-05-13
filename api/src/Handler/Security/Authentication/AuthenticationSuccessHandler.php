<?php

namespace App\Handler\Security\Authentication;

use App\Entity\Security\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private JWTTokenManagerInterface $jWTManager)
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        /**
         * @var User
         */
        $user = $token->getUser();
        $token = $this->jWTManager->createFromPayload($user, [
            'permissions' => ['PERMISSION_A', 'PERMISSION_B']
        ]);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
