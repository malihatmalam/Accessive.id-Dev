<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    // Tabel
    protected $table = 'guides';
    protected $guarded = [];
    protected $primaryKey = 'guide_id';

    // Relasi Place
    public function Place()
    {
        return $this->belongsTo('App\Place', 'place_id');
    }

    // Relasi Guide Photo
    public function GuidePhoto()
    {
        return $this->hasMany('App\GuidePhoto', 'guide_id');
    }

    // Relasi Guide Type
    public function GuideType()
    {
        return $this->belongsTo('App\GuideType', 'guide_type_id');
    }

    public function messages()
    {
        return [
            'input_Guide.notIn' => 'A title is required',
        ];
    }
}
