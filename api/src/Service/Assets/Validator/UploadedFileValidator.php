<?php

namespace App\Service\Assets\Validator;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UploadedFileValidator
{
    private ValidatorInterface $validator;
    private ValidationRulesFactory $validationFactory;

    public function __construct(ValidatorInterface $validator, ValidationRulesFactory $validationFactory)
    {
        $this->validator = $validator;
        $this->validationFactory = $validationFactory;
    }

    public function validateIconeFile(UploadedFile $uploadedFile)
    {
        $this->validateUploadedFile($uploadedFile, [
            'image/jpg', 'image/png', 'image/jpeg', 'image/svg+xml', 'image/svg', 'image/x-icon',
        ]);
    }

    protected function validateUploadedFile(
        ?UploadedFile $uploadedFile,
        array $mimeConstraints,
        int $maxSize = 0
    ) {
        if (null !== $uploadedFile) {
            //Build validation rules
            $validationRules = $this->validationFactory->buildConstraint($mimeConstraints, $maxSize);
            //Build constraints
            $faviconConstraints = new Assert\File($validationRules);

            //Validate uploaded file
            $errors = $this->validator->validate($uploadedFile, $faviconConstraints);
            if (count($errors) > 0) {
                throw new InvalidArgumentException('error.invalid.uploaded_file');
            }
        }
    }
}
