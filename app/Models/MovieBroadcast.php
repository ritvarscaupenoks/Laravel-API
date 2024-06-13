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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $exists = MovieBroadcast::where('movie_id', $model->movie_id)
                ->where('channel_nr', $model->channel_nr)
                ->whereDate('broadcasts_at', \Carbon\Carbon::parse($model->broadcasts_at)->toDateString())
                ->exists();

            if ($exists) {
                throw new \Exception('The movie is already scheduled on this channel for this day.');
            }
        });
    }
}
