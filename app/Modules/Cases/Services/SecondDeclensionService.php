<?php

namespace App\Modules\Cases\Services;

use App\Modules\Cases\Dto\CaseData;
use App\Modules\Cases\Enum\FormEnum;
use App\Modules\Cases\Enum\LetterEnum;

/**
 * Class SecondDeclensionService
 * @package App\Modules\Cases\Services
 */
class SecondDeclensionService
{
    public function getForm($caseData): array
    {
        switch ($this->checkForm($caseData)) {
            case (FormEnum::SOFT):
                $cases = $this->getSoftForm($caseData);
                break;
            case (FormEnum::SPECIAL):
                $cases = $this->getSpecialForm($caseData);
                break;
            case (FormEnum::SPECIAL_ENDING):
                $cases = $this->getComplexEndingForm($caseData);
                break;
            default:
                $cases = $this->getHardForm($caseData);
        }

        return $cases;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getSoftForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'и';
        $cases[] = $base . 'е';
        $cases[] = $base . 'ю';
        $cases[] = $base . 'ей';
        $cases[] = $base . 'е';

        return $cases;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getHardForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'ы';
        $cases[] = $base . 'е';
        $cases[] = $base . 'у';
        $cases[] = $base . 'ой';
        $cases[] = $base . 'е';

        return $cases;
    }

    /**
     * @param CaseData $caseData
     * @return string
     */
    private function checkForm(CaseData $caseData): string
    {
        $lengh = iconv_strlen($caseData->word) - 1;
        $consonant = null;
        $vovel = null;
        $form = FormEnum::HARD;

        for ($i = $lengh; $i >= 0; $i--) {
            $letter = mb_substr($caseData->word, $i, 1, 'utf-8');

            if (!in_array($letter, LetterEnum::VOVELS)) {
                $consonant = $letter;
                $vovel = mb_substr($caseData->word, $i + 1, 2, 'utf-8');
                break;
            }
        }

        if ($consonant !== null && in_array($consonant, LetterEnum::SOFT_CONSONANTS)) {
            $form = 'special';
        } elseif($vovel !== null && $vovel == 'ия') {
            $form = 'complex_ending';
        }elseif ($consonant !== null && $vovel !== null && in_array($vovel, LetterEnum::SOFT_VOVELS)) {
            $form = FormEnum::SOFT;
        }

        return $form;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getSpecialForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'и';
        $cases[] = $base . 'е';
        $cases[] = $base . 'у';
        $cases[] = $base . 'ой';
        $cases[] = $base . 'е';

        return $cases;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getComplexEndingForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'и';
        $cases[] = $base . 'и';
        $cases[] = $base . 'ю';
        $cases[] = $base . 'ей';
        $cases[] = $base . 'и';

        return $cases;
    }
}
