<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','password','user_name','role',
    ];

    protected $primaryKey = 'user_id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserData()
    {
        return $this->hasOne('App\UserData', 'user_id');
    }

    public function Review()
    {
        return $this->hasMany('App\Review', 'user_id');
    }

    // Relasi Collection (Place)
    public function Collection()
    {
        return $this->belongsToMany('App\Place', 'collections', 'user_id', 'place_id');
    }

    // Relasi Collection (Collection)
    public function CollectionHas()
    {
        return $this->hasMany('App\Collection', 'user_id');
    }

}
