<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'sub_category_id'
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function itemParameters()
    {
        return $this->hasMany(ItemParameter::class);
    }

}
