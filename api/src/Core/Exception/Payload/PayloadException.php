<?php

namespace App\Core\Exception\Payload;

use App\Core\Exception\JsonCustomException;
use Symfony\Component\HttpFoundation\Response;

class PayloadException extends JsonCustomException
{
    public static function invalidFormat(): JsonCustomException
    {
        return new JsonCustomException('Payload is not a valid json', Response::HTTP_BAD_REQUEST);
    }

    public static function missingRequiredKey(string $key): JsonCustomException
    {
        return new JsonCustomException(sprintf('Payload %s should have a non-empty value', $key), Response::HTTP_BAD_REQUEST);
    }

    public static function invalidEmail(string $key, string $email): JsonCustomException
    {
        return new JsonCustomException(sprintf('Payload %s with value %s is not valid email', $key, $email), Response::HTTP_BAD_REQUEST);
    }

    public static function csrfTokenInvalid(): JsonCustomException
    {
        return new JsonCustomException('CSRF Token invalid. Please reload the page', Response::HTTP_BAD_REQUEST);
    }

    public static function unknownPropriety(string $key, string $setters): JsonCustomException
    {
        return new JsonCustomException(sprintf("Property '%s' or method '%s' does not exists", $key, $setters), Response::HTTP_BAD_REQUEST);
    }
}
