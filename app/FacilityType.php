<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityType extends Model
{
    // Tabel
    protected $table = 'facility_types';
    protected $guarded = [];
    protected $primaryKey = 'facility_type_id';

    // Relasi Facility
    public function Facility()
    {
        return $this->hasMany('App\Facility', 'facility_type_id');
    }

    // Relasi Facility (Place)
    public function FacilityType()
    {
        return $this->belongsToMany('App\Place', 'facilities', 'facility_type_id', 'place_id');
    }

    // Relasi Facility Preference (User Data)
    public function UserData()
    {
        return $this->belongsToMany('App\UserData', 'facility_preferences', 'facility_type_id', 'user_data_id' );
    }

    public function messages()
    {
        return [
            'input_FacilityType.notIn' => 'A title is required',
        ];
    }
}
