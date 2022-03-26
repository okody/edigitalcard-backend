<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participaction extends Model
{
    use HasFactory;



    protected $fillable = [
        'id',
        'student_id',
        'session_id',

    ];

    public function student()
    {
        $this->belongsTo(Student::class);
    }


    // public function session()
    // {
    //     $this->hasOne(Session::class);
    // }
}
