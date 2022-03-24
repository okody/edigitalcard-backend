<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'image',

    ];

    public function shopItems()
    {
        return $this->hasMany(ShopItem::class);
    }
}
