<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityPreference extends Model
{
    // Tabel
    protected $table = 'facility_preferences';
    protected $guarded = [];
    protected $primaryKey = 'facility_preference_id';
}
