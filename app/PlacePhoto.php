<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacePhoto extends Model
{
    // Tabel
    protected $table = 'place_photos';
    protected $guarded = [];
    protected $primaryKey = 'place_photo_id';

    // Relasi Place
    public function Place()
    {
        return $this->belongsTo('App\Place', 'place_id');
    }
}
