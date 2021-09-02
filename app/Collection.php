<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    // Tabel
    protected $table = 'collections';
    protected $guarded = [];
    protected $primaryKey = 'collection_id';

    public function Place()
    {
        return $this->belongsTo('App\Place', 'place_id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
