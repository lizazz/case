<?php

namespace App\Modules\Cases\Enum;

/**
 * Class GenderEnum
 * @package App\Modules\Cases\Enum
 */
class GenderEnum
{
    const GENDER_MIDDLE = 1;
    const GENDER_MASCULINE = 2;
    const GENDER_FEMININE = 3;

    const GENDERS = [
        self::GENDER_MIDDLE => 'middle',
        self::GENDER_MASCULINE => 'masculine',
        self::GENDER_FEMININE => 'feminite',
    ];
}
