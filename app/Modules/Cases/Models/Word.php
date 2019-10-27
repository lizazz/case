<?php

namespace App\Modules\Cases\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Word extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function cases(): HasMany
    {
        return $this->hasMany(Cases::class);
    }

    /**
     * @return HasMany
     */
    public function statistic(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }
}
