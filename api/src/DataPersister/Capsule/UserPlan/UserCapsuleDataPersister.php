<?php

namespace App\DataPersister\Capsule\UserPlan;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Capsule\Balance\BalanceTransaction;
use App\Entity\Capsule\PlanPayment\PlanPayment;
use App\Entity\Capsule\UserCapsule\UserCapsule;
use App\Entity\Capsule\UserPlan\UserPlan;
use App\Repository\Capsule\Balance\UserBalanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class UserCapsuleDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private EntityManagerInterface $em, private MailerInterface $mailer)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @param UserCapsule $data
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof UserCapsule && ($context['collection_operation_name'] ?? null) === 'post';
    }

    /**
     * @param UserCapsule $data
     */
    public function persist($data, array $context = [])
    {
        $email = new NotificationEmail();
        $email->htmlTemplate('notification/email/security/authentication/user_capsule.twig')
            ->context(['email' => $data->getUser()->getEmail()])
            ->to($data->getUser()->getEmail())
            ->subject('Votre capsule a été créé avec succès');

        $email->mailer->send($email);

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
