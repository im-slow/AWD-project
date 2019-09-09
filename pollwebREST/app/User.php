<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [
        'name', 'surname', 'email', 'role'
    ];

    protected $dates = [];

    // public static $rules = [
    //     "name" => "required",
    //     "email" => "required",
    //     "password" => "required",
    //     "api_token" => "required",
    //     "role" => "required",
    // ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
     protected $hidden = [
         'password','api_token',
     ];

     public function myPoll(){
         return $this->hasMany(Poll::class,'IDuser');
     }

     // public function myInstance() {
     //     return $this->hasMany(Instance::class, 'IDuser');
     // }
}
