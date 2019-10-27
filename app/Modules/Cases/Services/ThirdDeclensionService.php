<?php

namespace App\Modules\Cases\Services;

/**
 * Class ThirdDeclensionService
 * @package App\Modules\Cases\Services
 */
class ThirdDeclensionService
{
    public function getForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'и';
        $cases[] = $cases[1];
        $cases[] = $cases[0];
        $cases[] = $base . 'ью';
        $cases[] = $cases[1];

        return $cases;
    }
}
