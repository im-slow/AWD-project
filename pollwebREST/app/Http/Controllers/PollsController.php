<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Poll;

use Illuminate\Support\Str;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PollsController extends Controller {

  //GET restituisce i nomi di tutti i sondaggi e il link per vederne i dettagli
  public function all() {
      $poll = Poll::all();

      if($poll->isEmpty()){
          $error = 'non e\' presente nessun sondaggio da visualizzare';
          return response()->json($error,Response::HTTP_NOT_FOUND);
      }

      $res = $poll->map->only(['title', 'URLPoll'])->all();

      return response()->json($res,Response::HTTP_OK);
  }

  public function get($id) {
      $poll = Poll::with('user')->find($id);

      if (is_null($poll)){
          $error = 'sondaggio non trovato';
          return response()->json($error,Response::HTTP_NOT_FOUND);
      }

      return response()->json($poll,Response::HTTP_OK);
  }

  // $this->validate($request, [
  //   'idNum' => 'require' // bho? |unique:users
  // ]);
  public function add(Request $request){
      if (Auth::user()->role == 'RES' || Auth::user()->role == 'ADMIN'){
          $IDuser = Auth::user()->id;
          $idNum = Str::random();
          $id = Poll::all()->max('id')+1;

          //TODO se si salta un id il prossimo sondaggio avrà URL sbagliato
          if(is_null($request->input('link'))) {
              $link = "http://localhost:8000/api/v1/poll/";
          } else {
              $link = $request->input('link');
          }

          $URLPoll = $link.$id;

          $request->request->add(['idNum' => $idNum, 'URLPoll' => $URLPoll, 'IDuser' => $IDuser]);

          // validator, se dei campi sono assenti, la richiesta non va a buonfine
          $validator = Validator::make($request->all(), [
            "idNum" => "required",
            "title" => "required",
            "openText" => "required",
            "closeText" => "required",
            "openPoll" => "required",
            "statePoll" => "required",
            "URLPoll" => "required",
            "IDuser" => "numeric|required",
          ]);

          if ($validator->fails()) {
              $error = $validator->errors();
              return response()->json($error,Response::HTTP_BAD_REQUEST);
          }

          $poll = Poll::create($request->all());

          return response()->json($poll,Response::HTTP_CREATED);
      } else {
          $err['msg'] = 'l\'utente non dispone dei permessi per accedere alla risorsa';
          return response()->json($err,Response::HTTP_FORBIDDEN);
      }

  }

  public function put(Request $request, $id){
    if(Auth::user()->id == $request->IDuser || Auth::user()->role == 'ADMIN'){
        $poll = Poll::find($id);
        if(is_null($poll)){
          $error = 'sondaggio da modificare non trovato';
          return response()->json($error, Response::HTTP_NOT_FOUND);
        }
        $updated = $poll->update($request->all());
        return response()->json(['updated' => $updated == 1], Response::HTTP_OK);
    } else {
        $error = 'non e\' possibile modificare il sondaggio';
        return response()->json($error, Response::HTTP_FORBIDDEN);
    }
  }

  public function remove($id){
    $poll= Poll::all()->find($id);
    if(is_null($poll)){
      $error = 'sondaggio non trovato';
      return response()->json($error,Response::HTTP_NOT_FOUND);
    }

    if(Auth::user()->id == $poll->IDuser || Auth::user()->role == 'ADMIN'){
        $count = Poll::destroy($id);
        return response()->json(['deleted' => $count == 1], Response::HTTP_OK);
    } else {
        $error = 'non e\' possibile cancellare il sondaggio';
        return response()->json($error, Response::HTTP_FORBIDDEN);
    }
  }
}
