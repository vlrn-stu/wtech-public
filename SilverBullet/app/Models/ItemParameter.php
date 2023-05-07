<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'sub_category_item_id'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function subCategoryItem()
    {
        return $this->belongsTo(SubCategoryItem::class);
    }
}
