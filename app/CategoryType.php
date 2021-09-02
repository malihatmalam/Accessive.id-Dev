<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    // Tabel
    protected $table = 'category_types';
    protected $guarded = [];
    protected $primaryKey = 'category_type_id';

    // Relasi Category
    public function category()
    {
        return $this->hasMany('App\Category', 'category_type_id');
    }
}
