<?php

namespace App\Service;

class RequestTypeGenerator
{
    const
        REQUEST_TYPE_ONE = 'one',
        REQUEST_TYPE_TWO = 'two',
        REQUEST_TYPE_THREE = 'three';

    const REQUEST_TYPES = [
        self::REQUEST_TYPE_ONE,
        self::REQUEST_TYPE_TWO,
        self::REQUEST_TYPE_THREE,
    ];

    public static function getType(): string
    {
        $index = rand(0, count(self::REQUEST_TYPES) - 1);

        return self::REQUEST_TYPES[$index];
    }
}
