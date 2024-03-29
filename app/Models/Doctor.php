<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'specialty', 'birth_date','roomName'
    ];

    protected $casts = [
        'birth_date' => 'datetime'
    ];

    // Define the relationship with the User model
    public function user()
    {
        
        return $this->belongsTo(User::class);
        
    }
}

