<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    const CATEGORY_NEW_FOOD = 'new_food';
    const CATEGORY_RECOMENDED = 'recomended';
    const CATEGORY_POPULAR = 'popular';
    
    protected $guarded = ['id'];

    /**
     * accessor, to custom value for specific attribute. 
     * before return to user.
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    /**
     * TODO: add assessor / mutator to return custom 
     * format name of attribute
     * HINT: using toArray function
     */
}
