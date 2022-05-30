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
                'fields' => $this->getFields(),
                'missingFieldsMessage' => 'Поле обязательно для заполнения.'
            ])
        ];
    }

    private function getFields(): array
    {
        return [
            'name' => new Assert\Required([
                new Assert\NotNull([
                    'message' => 'Значение не должно быть null.'
                ]),
                new Assert\NotBlank([
                    'message' => 'Значение не должно быть пустым.'
                ]),
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                    'minMessage' => 'Значение слишком короткое. Оно должно состоять из {{ limit }} символов или более.',
                    'maxMessage' => 'Значение слишком длинное. Оно должно содержать {{ limit }} символов или меньше.'
                ])
            ]),
            'dictionary' => new Assert\Required([
                new Assert\NotNull([
                    'message' => 'Значение не должно быть null.'
                ]),
                new Assert\File([
                    'maxSize' => '10M',
                    'mimeTypes' => ['text/csv', 'text/plain'],
                    'maxSizeMessage' => 'Файл слишком большой ({{ size }} {{ suffix }}). Допустимый максимальный размер: {{ limit }} {{ suffix }}.',
                    'mimeTypesMessage' => 'Файл должен быть в формате CSV.',
                    'notFoundMessage' => 'Не удалось найти файл.'
                ])
            ]),
            'images' => new Assert\Optional([
                new Assert\NotNull([
                    'message' => 'Значение не должно быть null.'
                ]),
                new Assert\File([
                    'maxSize' => '10M',
                    'mimeTypes' => ['application/zip'],
                    'maxSizeMessage' => 'Файл слишком большой ({{ size }} {{ suffix }}). Допустимый максимальный размер: {{ limit }} {{ suffix }}.',
                    'mimeTypesMessage' => 'Файл должен быть в формате ZIP.',
                    'notFoundMessage' => 'Не удалось найти файл.',
                ])
            ]),
        ];
    }
}