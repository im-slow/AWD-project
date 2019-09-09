<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Poll;
use App\Instance;
use App\Question;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InstancesController extends Controller {

    //partecipanti ad un sondaggio
    public function get(Request $request, $idpoll) {
        //$owner contiene dati solo se ha creato il sondaggio o é un admin
        $owner = Poll::with('user')->find($idpoll);
        if(is_null($owner)) {
            $error = 'sondaggio non trovato';
            return response()->json($error,Response::HTTP_NOT_FOUND);
        } else if (Auth::user()->role != 'ADMIN' || Auth::user()->id != $owner->IDuser) {
            $error = 'non puoi accedere alla risorsa';
            return response()->json($error,Response::HTTP_FORBIDDEN);
        } else {
            $instance = DB::table('instances')
                        ->join('users', 'users.id', 'instances.IDuser')
                        ->join('polls', 'polls.id', 'instances.IDuser')
                        ->where('IDpoll', $owner->id)
                        ->get(['name', 'surname', 'email', 'userStatus', 'submission']);

            if($instance->isEmpty()) {
                $error = 'nessun utente ha partecipato al sondaggio';
                return response()->json($error, Response::HTTP_NOT_FOUND);
            } else {
                return response()->json([$owner->title, $instance],Response::HTTP_OK);
            }
        }
    }

    //aggiungi partecipanti ad un sondaggio
    public function add(Request $request, $idpoll) {
      $poll = Poll::all()->find($idpoll);
      $owner = User::all()->find($poll->IDuser);

      if(Auth::user()->role != 'ADMIN' || Auth::user()->id != $owner->id){
          $error = 'non è possibile accedere alla risorsa';
          return response()->json($error,Response::HTTP_FORBIDDEN);
      } else {
          $validator = Validator::make($request->all(), [
            "IDuser" => "required|numeric"
          ]);

          if ($validator->fails()) {
              $error = $validator->errors();
              return response()->json($error,Response::HTTP_BAD_REQUEST);
          }

          $instance = new Instance;
          $instance->IDuser = $request->input('IDuser');
          $instance->IDpoll = $idpoll;

          if(is_null($request->input('userStatus'))) {
            $instance->userStatus = 0;
          } else {
            $instance->userStatus = $request->input('userStatus');
          }
          $instance->save();

          $message['message'] = "Instanza creata con successo";
          return response()->json($message,Response::HTTP_CREATED);
      }

    }

}
