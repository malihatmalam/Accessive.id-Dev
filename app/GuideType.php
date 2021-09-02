<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuideType extends Model
{
    // Tabel
    protected $table = 'guide_types';
    protected $guarded = [];
    protected $primaryKey = 'guide_type_id';

    // Relasi Guide 
    public function Guide()
    {
        return $this->hasMany('App\Guide', 'guide_type_id');
    }
}
