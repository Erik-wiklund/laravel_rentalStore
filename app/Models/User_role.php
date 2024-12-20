<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    use HasFactory;

    public function users()
    {
        $this->hasMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(User_role::class);
    }
}
