<?php

namespace App\Controller;

use App\Repository\Entity\Security\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DefaultController extends AbstractController
{
    public const TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTI0NDk0MzMsImV4cCI6MTY1MjQ1MzAzMywicm9sZXMiOltdLCJwZXJtaXNzaW9ucyI6WyJQRVJNSVNTSU9OX0EiLCJQRVJNSVNTSU9OX0IiXSwiZW1haWwiOiJtaWNoYW5pYWluYXJAZ21haWwuY29tIn0.NVevq692-rinGlIh9RHPy0FS32PYfwx09LibvLYT3nOu5hEtILeptpTZeobBzJ2hk4GUQeEvV4aYhgN6Jkq-cPCE-gm08UCe7l2AtOLS-9V4CU0gRVYvCKW3CT5Rd4o6iVUiTLYCrZ1KLaWgDUYjP5tChIWe9GH3n9KjaHz83qihWhxIPfTZl_AdCuy_Bz9mcORbIdge2b1MjmWU1k7nqHVyenU5Hw0gekRM02XiT9PgClYtpRPXGNwQTwtPGx3xj-50n50eGdCVB0lCC7aGnlQmZvLjOxbDgnt1BGFRnJXNvsDk93w5NXD9hyQJogiUh2M4JhKwPJ6zEkDkCpFJSQ";

    public function __construct(private JWTTokenManagerInterface $jWTManager)
    {
    }

    #[Route('', name: 'app_default')]
    public function __invoke(TokenStorageInterface $tokenStorageInterface, UserRepository $userRepository): Response
    {
        $user = null;
        $token = $tokenStorageInterface->getToken();

        dump($this->jWTManager->getUserIdentityField());

        if (null !== $token) {
            dump('Existing token');
            $user = $token->getUser();
            // $user = $userRepository->findOneByEmail('michaniainar@gmail.com');

            // $this->jWTManager->createFromPayload($user, [
            //     'permissions' => [
            //         'A', 'B'
            //     ]
            // ]);

            // dump($this->jWTManager->parse(self::TOKEN));
        }

        dd($user);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
