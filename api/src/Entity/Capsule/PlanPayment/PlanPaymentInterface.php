<?php

namespace App\Entity\Capsule\PlanPayment;

interface PlanPaymentInterface
{
    public const PAYMENT_STATUS_INITIALIZED = 'payment.status.initialized';
    public const PAYMENT_STATUS_DONE        = 'payment.status.done';
    public const PAYMENT_STATUS_CANCELED    = 'payment.status.canceled';
}
