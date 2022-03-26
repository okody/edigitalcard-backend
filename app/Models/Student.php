<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        "image",
        "name",
        "username",
        "password",
        "collage",
        "department",
        "email",
        "collectedPoints"
    ];

    public function collectedPoints()
    {
        return $this->hasMany(CollectedPoint::class);
    }


    public function participaction()
    {
        return $this->belongsToMany(Session::class, "participactions", "student_id", "session");
    }
}
