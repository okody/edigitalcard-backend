<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        "place",
        "fromDate",
        "toDate",
        "fromTime",
        "toTime",
        "scores"
    ];


    public function participactions()
    {
        return $this->belongsToMany(Student::class, "participactions");
    }
}
