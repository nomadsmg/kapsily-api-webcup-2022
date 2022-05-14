<?php

namespace App\Action\Security;

use App\Action\ApiAbstractAction;
use App\Entity\Security\SecurityInterface;
use App\Entity\Security\User;
use App\Repository\Capsule\Config\PricingPlan\PricingPlanRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/api/me', methods: Request::METHOD_GET, name: 'api_user_profile')]
class UserProfileAction extends ApiAbstractAction
{
    public function __construct(private TokenStorageInterface $tokenStorage, private SerializerInterface $serializer, private PricingPlanRepository $pricingPlanRepository)
    {
    }

    public function __invoke(): JsonResponse
    {
        /**
         * @var User
         */
        $user = $this->tokenStorage->getToken()?->getUser();

        $userPayload = json_decode($this->serializer->serialize($user, 'json', [
            'groups' => SecurityInterface::GP_PROFILE
        ]), true);

        $userCurrentPlanIdentifier = $user->getCurrentPlan(true);

        if (null !== $userCurrentPlanIdentifier) {
            $userPayload['current_plan'] = $userCurrentPlanIdentifier;
        } else {
            $userPayload['current_plan'] = $this->pricingPlanRepository->getDefaultFreePricingPlan()->getIdentifier();
        }

        return $this->sendJsonSuccess([
            'user' => $userPayload,
        ]);
    }
}
