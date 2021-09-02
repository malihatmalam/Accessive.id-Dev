<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuidePhoto extends Model
{
    // Tabel
    protected $table = 'guide_photos';
    protected $guarded = [];
    protected $primaryKey = 'guide_photo_id';

    // Relasi Guide
    public function Guide()
    {
        return $this->belongsTo('App\Guide', 'guide_id');
    }
}
