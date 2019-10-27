<?php

namespace App\Modules\Cases\Services;
use App\Modules\Cases\Dto\CaseData;
use App\Modules\Cases\Enum\GenderEnum;
use App\Modules\Cases\Enum\LetterEnum;

/**
 * Class FirstDeclensionService
 * @package App\Modules\Cases\Services
 */
class FirstDeclensionService
{
    public function getForm($caseData): array
    {
        if ($this->isSoft($caseData)) {
            if ($caseData->gender == GenderEnum::GENDERS[GenderEnum::GENDER_MIDDLE]) {
                $cases = $this->getFirstSoftMiddleForm($caseData);
            } else {
                $cases = $this->getFirstSoftMasculineForm($caseData);
            }
        } else {
            if ($caseData->gender == GenderEnum::GENDERS[GenderEnum::GENDER_MIDDLE]) {
                $cases = $this->getFirstHardMiddleForm($caseData);
            } else {

                $cases = $this->getFirstHardMasculineForm($caseData);
            }
        }

        return $cases;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getFirstSoftMiddleForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'я';
        $cases[] = $base . 'ю';
        $cases[] = $base . 'е';
        $cases[] = $base . 'ем';
        $cases[] = $base . 'е';

        return $cases;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getFirstHardMiddleForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'а';
        $cases[] = $base . 'у';
        $cases[] = $base . 'о';
        $cases[] = $base . 'ом';
        $cases[] = $base . 'е';

        return $cases;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getFirstHardMasculineForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = $caseData->word;
        $cases[] = $base . 'а';
        $cases[] = $base . 'у';

        if (!$caseData->is_enthusiastic) {
            $cases[] = $cases[0];
        } else {
            $cases[] = $cases[1];
        }

        $cases[] = $base . 'ом';
        $cases[] = $base . 'е';

        return $cases;
    }

    /**
     * @param $caseData
     * @return array
     */
    private function getFirstSoftMasculineForm($caseData): array
    {
        $cases = [$caseData->word];
        $base = mb_substr($caseData->word, 0, iconv_strlen($caseData->word) -1, 'utf-8');
        $cases[] = $base . 'я';
        $cases[] = $base . 'ю';

        if (!$caseData->is_enthusiastic) {
            $cases[] = $cases[0];
        } else {
            $cases[] = $cases[1];
        }

        $cases[] = $base . 'ем';
        $cases[] = $base . 'е';

        return $cases;
    }

    /**
     * @param CaseData $caseData
     * @return bool
     */
    private function isSoft(CaseData $caseData): bool
    {
        $lengh = iconv_strlen($caseData->word) - 1;
        $consonant = null;
        $vovel = null;
        $isSoft = false;

        for ($i = $lengh; $i >= 0; $i--) {
            $letter = mb_substr($caseData->word, $i, 1, 'utf-8');

            if (!in_array($letter, LetterEnum::VOVELS)) {
                $consonant = $letter;
                $vovel = mb_substr($caseData->word, $i + 1, 1, 'utf-8');
                break;
            }
        }

        if ($consonant !== null && !in_array($consonant, LetterEnum::HARD_CONSONANTS) &&
            (($vovel !== null && in_array($vovel, LetterEnum::SOFT_VOVELS)))) {
            $isSoft = true;
        }

        return $isSoft;
    }
}
