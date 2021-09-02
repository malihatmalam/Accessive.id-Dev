<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Tabel
    protected $table = 'categories';
    protected $guarded = [];
    protected $primaryKey = 'category_id';

    // Relasi Category Type
    public function categoryType()
    {
        return $this->belongsTo('App\CategoryType', 'category_type_id');
    }

    // Relasi Place
    public function Place()
    {
        return $this->hasMany('App\Place', 'category_id');
    }

}
