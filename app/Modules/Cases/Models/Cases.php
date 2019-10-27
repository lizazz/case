<?php

namespace App\Modules\Cases\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $table = 'cases';
    protected $guarded = ['id'];
}
