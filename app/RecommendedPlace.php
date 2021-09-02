<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecommendedPlace extends Model
{
    // Tabel
    protected $table = 'recommended_places';
    protected $guarded = [];
    protected $primaryKey = 'recommended_place_id';

    // Relasi Place
    public function Place()
    {
        return $this->belongsTo('App\Place', 'place_id');
    }
}
