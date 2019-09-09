<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model {

    public $timestamps = false;

    protected $fillable = ["idNum", "title", "openText", "closeText", "openPoll", "statePoll", "URLPoll", "IDuser"];

    protected $hidden = ["IDuser"];

    protected $dates = [];

    public static $rules = [
        "idNum" => "required",
        "title" => "required",
        "openText" => "required",
        "closeText" => "required",
        "openPoll" => "required",
        "statePoll" => "required",
        "URLPoll" => "required",
        "IDuser" => "numeric|required",
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'IDuser');
    }

    public function myQuestion() {
        return $this->hasMany(Question::class,'IDpoll');
    }

    public function myInstance() {
        return $this->hasMany(Instance::class, 'IDpoll');
    }


}
