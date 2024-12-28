<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVShow extends Model
{
    use HasFactory;

    protected $table = 'tvshows';

    public function tvshow()
    {
        return $this->belongsTo(TVShow::class, 'tvshows_id');
    }
}
