<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {

    public $timestamps = false;

    protected $fillable = ["answer", "IDquestion"];

    protected $dates = [];

    protected $hidden = ["id", "IDquestion"];

    public static $rules = [
        "answer" => "required",
        "IDquestion" => "numeric",
    ];

    public function question() {
        return $this->hasOne(Question::class, 'id', IDquestion);
    }

    public function myInstance() {
        return $this->belongToMany(Instance::class, 'answer_instances');
    }
}
