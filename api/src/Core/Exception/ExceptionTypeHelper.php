<?php

namespace App\Core\Exception;

use App\Core\Exception\Payload\InvalidPayloadException;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExceptionTypeHelper
{
    public static function isNotFoundException(\Exception $exception): bool
    {
        return in_array(get_class($exception), self::getNotFoundExceptions());
    }

    public static function isMalformedException(\Exception $exception): bool
    {
        return in_array(get_class($exception), self::getInvalidPayloadExptions());
    }

    private static function getNotFoundExceptions(): array
    {
        return [
            EntityNotFoundException::class,
            FileNotFoundException::class,
            ApiNotFoundException::class,
        ];
    }

    private static function getInvalidPayloadExptions()
    {
        return [
            BadRequestHttpException::class,
            InvalidPayloadException::class,
        ];
    }
}