<?php

// Secretary model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Secretary extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'doctors_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

