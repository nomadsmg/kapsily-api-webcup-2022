<?php

namespace App\Manager\UserCapsule;

use App\Entity\Capsule\UserCapsule\UserCapsule;
use App\Entity\Media\Media;
use App\Manager\Media\MediaManager;
use App\Repository\Entity\Security\UserRepository;
use App\Service\Assets\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class UserCapsuleManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private ParameterBagInterface $parameterBag,
        private MediaManager $mediaManager,
        private UserRepository $userRepository
    ) {
    }

    public function addFromRequest(Request $request): UserCapsule
    {
        $userCapsule = new UserCapsule();

        $user = $this->userRepository->getUserByUuid($request->request->get('user'));

        /**
         * @var UploadedFile $mediaFile
         */
        // foreach ($request->files->get('media') as $mediaFile) {
        //     $capsuleMedia = $this->mediaManager->uploadMedia($mediaFile, 'media');

        //     $userCapsule->addMedia($capsuleMedia);
        // }

        if (null !== $request->files->get('media')) {
            $capsuleMedia = $this->mediaManager->uploadMedia($request->files->get('media'), 'media');
            $userCapsule->addMedia($capsuleMedia);
        }

        $userCapsule
            ->setUser($user)
            ->setLocation($request->request->get('location'))
            ->setLifetime(null !== $request->request->get('lifetime') ? $request->request->get('lifetime') : $user->getCurrentPlan()->getPricingPlan()->getYears());

        $this->em->persist($userCapsule);
        $this->em->flush();

        return $userCapsule;
    }
}
