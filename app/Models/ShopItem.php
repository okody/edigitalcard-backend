<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        "image",
        "title",
        "description",
        'price',
        "quantity",
        "shop_id"

    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
