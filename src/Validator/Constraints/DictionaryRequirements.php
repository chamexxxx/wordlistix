<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

class DictionaryRequirements extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Collection([
                'name' => new Assert\Required([
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255])
                ]),
                'dictionary' => new Assert\Required([
                    new Assert\NotNull(),
                    new Assert\File([
                        'maxSize' => '10M',
                        'mimeTypes' => ['text/csv', 'text/plain']
                    ])
                ]),
                'images' => new Assert\Optional([
                    new Assert\NotNull(),
                    new Assert\File([
                        'maxSize' => '10M',
                        'mimeTypes' => ['application/zip']
                    ])
                ]),
            ])
        ];
    }
}