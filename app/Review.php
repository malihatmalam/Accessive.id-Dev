<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Tabel
    protected $table = 'reviews';
    protected $guarded = [];
    protected $primaryKey = 'review_id';

    // Relasi User
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // Relasi Place
    public function Place()
    {
        return $this->belongsTo('App\Place', 'place_id');
    }
}
