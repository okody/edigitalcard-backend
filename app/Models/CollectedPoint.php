<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectedPoint extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'action',
        'points',
        'service',
        'collectionDate',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
