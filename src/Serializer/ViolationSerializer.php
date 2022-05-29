<?php

namespace App\Serializer;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationSerializer
{
    public static function convertToArray(ConstraintViolationListInterface $violations): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $errors = [];

        foreach ($violations as $violation) {
            $entryErrors = (array) $propertyAccessor->getValue($errors, $violation->getPropertyPath());

            $entryErrors[] = $violation->getMessage();

            $propertyAccessor->setValue($errors, $violation->getPropertyPath(), $entryErrors);
        }

        return $errors;
    }
}