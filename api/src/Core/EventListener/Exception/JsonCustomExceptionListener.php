<?php

namespace App\Core\EventListener\Exception;

use App\Core\Exception\JsonCustomException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class JsonCustomExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof JsonCustomException) {
            return;
        }

        $responseData = [
            'data' => [
                'validation' => $exception->getMessage(),
            ],
            'status' => 'error',
        ];

        $event->setResponse(new JsonResponse($responseData, $exception->getCode()));
    }
}