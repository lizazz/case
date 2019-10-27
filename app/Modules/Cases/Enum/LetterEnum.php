<?php

namespace App\Modules\Cases\Enum;

/**
 * Class LetterEnum
 * @package App\Modules\Cases\Enum
 */
class LetterEnum
{
    const VOVELS = [
        'а',
        'е',
        'ё',
        'и',
        'о',
        'у',
        'ы',
        'э',
        'ю',
        'я',
        'А',
        'Е',
        'Ё',
        'И',
        'О',
        'У',
        'Ы',
        'Э',
        'Ю',
        'Я',
        'ь'
    ];
    const SOFT_CONSONANTS = ['г', 'к', 'х', 'ц', 'ж', 'ч', 'щ', 'ш'];
    const SOFT_VOVELS = ['е', 'ё', 'и', 'ю', 'я', 'ь'];
    const HARD_CONSONANTS = ['ж', 'ш', 'ц'];
}
