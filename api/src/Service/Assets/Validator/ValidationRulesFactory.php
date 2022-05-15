<?php

namespace App\Service\Assets\Validator;

class ValidationRulesFactory
{
    public function buildConstraint(array $mimeTypes, int $maxSize = 0): array
    {
        if (0 !== $maxSize) {
            return [
                'mimeTypes' => $mimeTypes,
                'maxSize' => sprintf('%dk', $maxSize),
            ];
        }

        return [
            'mimeTypes' => $mimeTypes,
        ];
    }
}
