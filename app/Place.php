<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    // Tabel
    protected $table = 'places';
    protected $guarded = [];
    protected $primaryKey = 'place_id';

    // Relasi Category
    public function Category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    // Relasi Place Photo
    public function PlacePhoto()
    {
        return $this->hasMany('App\PlacePhoto', 'place_id');
    }

    // Relasi Recommended Place
    public function RecommendedPlace()
    {
        return $this->hasOne('App\RecommendedPlace', 'place_id');
    }

    // Relasi Guide
    public function Guide()
    {
        return $this->hasMany('App\Guide', 'place_id');
    }

    // Relasi Facility (Facility Type)
    public function FacilityType()
    {
        return $this->belongsToMany('App\FacilityType', 'facilities', 'place_id', 'facility_type_id');
    }

    // Relasi Facility (Facility)
    public function Facility()
    {
        return $this->hasMany('App\Facility', 'place_id');
    }

    // Relasi Collection (Collection)
    public function CollectionHas()
    {
        return $this->hasMany('App\Collection', 'place_id');
    }

    // Relasi Collection (User)
    public function Collection()
    {
        return $this->belongsToMany('App\User', 'collections', 'place_id', 'user_id');
    }

    // Relasi Review
    public function Review()
    {
        return $this->hasMany('App\Review', 'place_id');
    }

    public function messages()
    {
        return [
            'input_Place.notIn' => 'A title is required',
        ];
    }
}
