<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

class DictionaryCsvHeader extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\All([
                new Assert\Choice([
                    'choices' => array_merge(
                        ['Image'],
                        self::getAllowedLanguages()
                    ),
                    'message' => 'Значение заголовка столбца недопустимо. Разрешенные варианты: {{ choices }}'
                ])
            ])
        ];
    }

    public static function getAllowedLanguages(): array
    {
        return [
            'RUS', 'ENG',
        ];
    }
}