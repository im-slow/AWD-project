<?php

namespace App\Http\Controllers;

use Auth;

use App\Question;
use App\Poll;

use Illuminate\Support\Str;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller {

    public function all($idpoll) {
        $question = Question::all()->where('IDpoll', $idpoll)->pluck('questionText', 'positionNumber');

        if($question->isEmpty()) {
            $error = 'non sono presenti domande per questo sondaggio';
            return response()->json($error,Response::HTTP_NOT_FOUND);
        }

        return response()->json($question,Response::HTTP_OK);
    }

    public function get($idpoll, $id) {
        $question = Question::all()->where('IDpoll', $idpoll)->where('id', $id)->first();

        if(is_null($question)){
            $error = 'la domanda selezionata non esiste';
            return response()->json($error,Response::HTTP_NOT_FOUND);
        }

        return response()->json($question,Response::HTTP_OK);
    }

    public function add(Request $request, $idpoll) {
        if (Auth::user()->id == $request->input('IDuser') || Auth::user()->role == 'ADMIN') {

            $uniqueCode = Str::random();
            $positionNumber = Question::all()->where('IDpoll', $idpoll)->pluck('positionNumber');
            $value = $positionNumber->max();

            if(is_null($value)){
                $value = 1;
            } else {
                $value = $value + 1;
            }

            $request->request->add(['uniqueCode'=>$uniqueCode, 'positionNumber'=>$value, 'IDpoll'=>$idpoll]);

            $validator = Validator::make($request->all(), [
              "questionText" => "required",
              "questionType" => "required",
              "questionOption" => "required",
              "uniqueCode" => "required",
              "positionNumber" => "required",
              "IDpoll" => "required|numeric"
            ]);

            if ($validator->fails()) {
                $error = $validator->errors();
                return response()->json($error,Response::HTTP_BAD_REQUEST);
            }

            $question = Question::create($request->all());

        } else {
            $error = 'non e\' possibile aggiungere una domanda a questo sandaggio';
            return response()->json($error,Response::HTTP_FORBIDDEN);
        }

        if(is_null($question)){
          $error = 'error';
          return response()->json($error,Response::HTTP_NOT_FOUND);
        }
        return response()->json($question,Response::HTTP_CREATED);
    }

    public function put(Request $request, $id, $idpoll) {
        if(Auth::user()->id == $request->input('IDuser') || Auth::user()->role == 'ADMIN'){
            $question = Question::find($id);

            if(is_null($question)){
                $error = 'domanda non trovata';
                return response()->json($error,Response::HTTP_NOT_FOUND);
            } else {
                $updated = $question->update($request->all());
                return response()->json(['updated' => $updated],Response::HTTP_OK);
            }

        } else {
            $error = 'non e\' possibile modificare il sondaggio';
            return response()->json($error,Response::HTTP_FORBIDDEN);
        }
    }

    public function remove($id, $idpoll) {
      $poll = Poll::find($idpoll);
      if(Auth::user()->id == $poll->IDuser || Auth::user()->role == 'ADMIN'){
          $count = Question::destroy($id);
          return response()->json(['deleted' => $count == 1], Response::HTTP_OK);
      } else {
          $error = 'non e\' possibile cancellare il sondaggio';
          return response()->json($error,Response::HTTP_FORBIDDEN);
      }
    }

}
