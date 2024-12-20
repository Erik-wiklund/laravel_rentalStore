<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'views_count',
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function incrementViewCount()
    {
        $this->increment('views_count');
    }

    public function lockedBy()
    {
        return $this->belongsTo(AdminLog::class, 'user_id');
    }

    // public function adminLogs()
    // {
    //     return $this->hasMany(AdminLog::class, 'movie_id');
    // }

    public function admin()
    {
        return $this->belongsTo(AdminLog::class, 'user_id');
    }
}
