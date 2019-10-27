<?php

namespace App\Modules\Cases\Presenters;

use Hemp\Presenter\Presenter;

/**
 * Class WordPresenter
 * @package App\Modules\Cases\Presenters
 */
class WordPresenter extends Presenter
{
    /**
     * @var array
     */
    public $hidden = ['updated_at', 'created_at'];

    /**
     * @return array|mixed
     */
    public function getCasesAttribute()
    {
        return $this->model->cases->pluck('case');
    }
}
