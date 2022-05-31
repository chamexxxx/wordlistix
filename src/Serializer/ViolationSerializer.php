<?php

namespace App\Serializer;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationSerializer
{
    public static function convertToArrayWithPropertyAccessor(ConstraintViolationListInterface $violations): array
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

    public static function convertToArray(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errors;
    }
}