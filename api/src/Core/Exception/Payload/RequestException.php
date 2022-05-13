<?php

namespace App\Core\Exception\Payload;

use App\Core\Exception\JsonCustomException;
use Symfony\Component\HttpFoundation\Response;

class RequestException extends JsonCustomException
{
    public static function unexceptedMethod(string $commingMethod, string $exceptedMethod): JsonCustomException
    {
        return new JsonCustomException(sprintf('Method %s Not Allowed (Allowed: %s)', $commingMethod, $exceptedMethod), Response::HTTP_BAD_REQUEST);
    }
}
