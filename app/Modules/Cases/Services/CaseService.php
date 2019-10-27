<?php

namespace App\Modules\Cases\Services;

use App\Modules\Cases\Dto\CaseData;
use App\Modules\Cases\Enum\GenderEnum;

/**
 * Class CaseService
 * @package App\Modules\Cases\Services
 */
class CaseService
{
    /**
     * @var FirstDeclensionService
     */
    protected $firstDeclensionService;

    /**
     * @var SecondDeclensionService
     */
    protected $secondDeclensionService;

    /**
     * @var ThirdDeclensionService
     */
    protected $thirdDeclensionService;

    /**
     * CaseService constructor.
     * @param FirstDeclensionService $firstDeclensionService
     * @param SecondDeclensionService $secondDeclensionService
     * @param ThirdDeclensionService $thirdDeclensionService
     */
    public function __construct(
        FirstDeclensionService $firstDeclensionService,
        SecondDeclensionService $secondDeclensionService,
        ThirdDeclensionService $thirdDeclensionService
    ) {
        $this->firstDeclensionService = $firstDeclensionService;
        $this->secondDeclensionService = $secondDeclensionService;
        $this->thirdDeclensionService = $thirdDeclensionService;
    }

    /**
     * @param CaseData $caseData
     * @return int
     */
    public function getDeclension(CaseData $caseData): int
    {
        $declension = 3;
        $end = mb_substr($caseData->word, -1, 1, 'utf-8');

        if ($caseData->gender == GenderEnum::GENDERS[GenderEnum::GENDER_MASCULINE] ||
            ($caseData->gender == GenderEnum::GENDERS[GenderEnum::GENDER_MIDDLE] && in_array($end, ['о', 'е']))) {
            $declension = 1;
        }

        if (in_array($end, ['а', 'я'])) {
            $declension = 2;
        }

        return $declension;
    }



    /**
     * @param CaseData $caseData
     * @return array
     */
    public function transform(CaseData $caseData): array
    {
        switch ($caseData->declension) {
            case 1:
                $response = $this->firstDeclensionService->getForm($caseData);
                break;
            case 2:
                $response = $this->secondDeclensionService->getForm($caseData);
                break;
            case 3:
                $response = $this->thirdDeclensionService->getForm($caseData);
                break;
            default:
                $response = ['error' => __('cases::case.cant_transform')];
        }
        return $response;
    }
}
