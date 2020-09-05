<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    //use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movies';

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'release_date',
        'duration',
        'genre',
    ];
}
