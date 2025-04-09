<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'token',
        'expires_at',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
