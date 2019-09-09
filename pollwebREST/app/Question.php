<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {

    public $timestamps = false;

    protected $fillable = ["positionNumber", "uniqueCode", "questionText", "note", "mandatory", "questionType", "minimum", "maximum", "questionOption", "IDpoll"];

    protected $dates = [];

    protected $hidden = ["id", "IDpoll"];

    public static $rules = [
        "positionNumber" => "required",
        "uniqueCode" => "required",
        "questionText" => "required",
        "note" => "required",
        "mandatory" => "required",
        "questionType" => "required",
        "minimum" => "required",
        "maximum" => "required",
        "questionOption" => "required",
        "IDpoll" => "numeric",
    ];

    public function poll()
    {
        return $this->hasOne(Poll::class, 'id', 'IDpoll');
    }


}
