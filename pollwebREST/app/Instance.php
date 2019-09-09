<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model {

    public $timestamps = false;

    protected $fillable = ["userStatus", "submission", "IDuser", "IDpoll"];

    protected $hidden = ["IDuser", "IDpoll", "id"];

    protected $dates = [];

    public static $rules = [
        "userStatus" => "required",
        "submission" => "required",
        "IDuser" => "numeric",
        "IDpoll" => "numeric",
    ];

    public function poll() {
        return $this->hasOne(Poll::class, 'id', 'IDpoll');
    }

    // public function user() {
    //     return $this->hasOne(User::class, 'id', 'IDuser');
    // }

    public function myAnswer() {
        return $this->belongToMany(Answer::class, 'answer_instances');
    }


}
