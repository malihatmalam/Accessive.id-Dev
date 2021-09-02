<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    // Tabel
    protected $table = 'user_datas';
    protected $guarded = [];
    protected $primaryKey = 'user_data_id';

    // Relasi User
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // Relasi Facility Preference (Facility Type)
    public function FacilityType()
    {
        return $this->belongsToMany('App\FacilityType', 'facility_preferences', 'user_data_id', 'facility_type_id' );
    }

    public function messages()
    {
        return [
            'input_UserData.notIn' => 'A title is required',
        ];
    }
}
