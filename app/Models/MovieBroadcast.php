<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieBroadcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'channel_nr',
        'broadcasts_at',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
