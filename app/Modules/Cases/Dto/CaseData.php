<?php

namespace App\Modules\Cases\Dto;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class CaseData
 * @package App\Modules\Cases\Dto
 */
class CaseData extends DataTransferObject
{
    public $gender;
    public $email;
    public $word;
    public $declension;
    public $is_enthusiastic;
}
