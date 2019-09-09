<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Poll;
use App\Question;
use App\Answer;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswersController extends Controller {

    //risposte a un domanda di un sondaggio
    public function get($idpoll, $idquestion) {

        $poll = Poll::all()->find($idpoll);
        $user = User::all()->find($poll->IDuser);
        $question = Question::all()->find($idquestion)->where('id', $idquestion)->pluck('questionText')->first();

        if(Auth::user()->role == 'ADMIN' || Auth::user()->id == $user->id){
            $answer = Answer::where('IDquestion', $idquestion)->get();
        } else {
            $error = 'non si hanno i permessi per accedere alla risorsa';
            return response()->json($error,Response::HTTP_FORBIDDEN);
        }

        if($answer->isEmpty()){
          $error = 'nessun utente ha risposto al sondaggio';
          return response()->json($error, Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([$idquestion.": ".$question, $answer],Response::HTTP_OK);
        }

    }

}
