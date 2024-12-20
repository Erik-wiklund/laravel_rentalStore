<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reporter',
        'reported_movie',
        'reason',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'reporter');
    }

    public function reportss()
    {
        return $this->hasMany(Report::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'reported_movie');
    }

    public function reportedItem()
    {
        return $this->morphTo();
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportedItem');
    }
}
