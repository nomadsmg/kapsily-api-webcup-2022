<?php

namespace App\Action\Security\Authentication;

use App\Action\ApiAbstractAction;
use App\Dto\Security\Authentication\LoginRequestInputDto;
use App\Entity\Security\User;
use App\Notifier\Security\Authentication\MagicLinkNotification;
use App\Repository\Security\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

#[Route(path: "/magic-link")]
class MagicLinkAuthenticationAction extends ApiAbstractAction
{
    #[Route(path: "/login", name: "magic_link_login")]
    public function login(
        Request $request,
        NotifierInterface $notifier,
        LoginLinkHandlerInterface $loginLinkHandler,
        UserRepository $userRepository,
        LoginRequestInputDto $loginInputDto,
        AuthenticationUtils $authenticationUtils
    ) {
        if ($request->isMethod(Request::METHOD_POST)) {
            $user = $userRepository->findOneByCredential($loginInputDto->email);

            if (!$user) {
                return $this->sendJsonError([
                    'message' => sprintf('User account with email %s not found', $loginInputDto->email),
                ]);
            }

            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);

            // create a notification based on the login link details
            $notification = new MagicLinkNotification(
                $loginLinkDetails,
                'Sign with magic link' // email subject
            );

            // send the notification to the user
            $notifier->send(
                $notification,
                new Recipient('michaniainar@gmail.com')
            );

            return $this->redirectToRoute('magic_link_check_email');
        }

        return $this->render('magic_link/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    #[Route(path: "/login/check-email", name: "magic_link_check_email")]
    public function magicLinkCheckEmail(Request $request): Response
    {
        return $this->render('magic_link/check_email.html.twig');

        // return $this->render('security/process_login_link.html.twig', [
        //     'expires' => $request->query->get('expires'),
        //     'user' => $request->query->get('user'),
        //     'hash' => $request->query->get('hash'),
        // ]);
    }

    #[Route(path: "/login/verify", name: "magic_link_verify")]
    public function checkMagicLink(): void
    {
        throw new \Exception('will be handled by authenticator');
    }

    #[Route(path: "/logout", name: "security_logout", methods: Request::METHOD_GET)]
    public function logout(): void
    {
        return;
    }
}
