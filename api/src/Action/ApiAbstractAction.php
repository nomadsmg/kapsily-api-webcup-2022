<?php

namespace App\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiAbstractAction extends AbstractController
{
    public const SUCCESS = "success";
    public const ERROR = "error";

    protected function getRawParameters(Request $request): array
    {
        return json_decode($request->getContent(), true);
    }

    protected function sendJsonSuccess(array $payload, array $extraFields = [], int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->json([
            'status' => self::SUCCESS,
            $payload,
            ...$extraFields,
        ], $code);
    }

    protected function sendJsonError(array $validation, array $extraFields = [], int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->json([
            'status' => self::ERROR,
            $validation,
            ...$extraFields,
        ], $code);
    }
}
