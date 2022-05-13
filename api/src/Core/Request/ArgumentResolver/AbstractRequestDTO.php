<?php

namespace App\Core\Request\ArgumentResolver;

use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequestDTO implements RequestDTOInterface
{
    protected array $payload = [];

    public function __construct(private Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $this->payload = json_decode('' !== $request->getContent() ? $request->getContent() : '{}', true);
        } else {
            $this->payload = $request->request->all();
        }
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getRequestFiles(string $key): array
    {
        /**
         * @var FileBag $files
         */
        $files = $this->request->files;

        if ($files && $filesByKey = $files->get($key)) {
            return $filesByKey;
        }

        return [];
    }
}
