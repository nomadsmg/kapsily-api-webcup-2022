<?php

namespace App\Core\Request\ArgumentResolver;

use App\Core\Exception\Payload\InvalidPayloadException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDTOResolver implements ArgumentValueResolverInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        try {
            $reflection = new \ReflectionClass($argument->getType());

            if ($reflection->implementsInterface(RequestDTOInterface::class)) {
                return true;
            }
        } catch (\ReflectionException $e) {
            return false;
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $class = $argument->getType();
        $dto = new $class($request);

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $errorDetails = [];

            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorDetails[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new InvalidPayloadException(json_encode($errorDetails), Response::HTTP_BAD_REQUEST);
        }

        yield $dto;
    }
}
