<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    // Tabel
    protected $table = 'facilities';
    protected $guarded = [];
    protected $primaryKey = 'facility_id';

    // Relasi Facility Type
    public function FacilityType()
    {
        return $this->belongsTo('App\FacilityType', 'facility_type_id');
    }

    // Relasi Place
    public function place()
    {
        return $this->belongsTo('App\Place', 'place_id');
    }
}
