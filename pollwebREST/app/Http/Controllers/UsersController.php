<?php

namespace App\Http\Controllers;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller {

  public function signin(Request $request) {
    $this->validate($request, [
          'name' => 'required',
          'surname' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:8|max:32',
      ]);

      $user = new User;
      $user->name = $request->input('name');
      $user->surname = $request->input('surname');
      $user->email = $request->input('email');
      $user->password = app('hash')->make($request->input('password'));
      $user->role = 'USER';
      $user->api_token = base64_encode(Str::random(60));

      $user->save();

      return response()->json($user,Response::HTTP_CREATED);
  }

  public function login(Request $request) {
      $user = User::all()->where('email', $request->input('email'))->first();
          if(Hash::check($request->input('password'), $user->password)){
              $token['token'] = $user->api_token;
            return response()->json($token,Response::HTTP_OK);
          } else {
              $message['message'] = 'Impossibile effettuare login';
              return response()->json($message,Response::HTTP_NOT_FOUND);
          }
  }

  public function logout() {
      if (Auth::user()){
          $logout = User::all()->find(Auth::id());
          if (is_null($logout)){
              return response()->json(Response::HTTP_NOT_FOUND);
          } else {
              $newToken = base64_encode(Str::random(60));
              $logout->api_token = $newToken;
              $logout->save();
              $message['message'] = 'Logout eseguito con successo!';
              return response()->json($message,Response::HTTP_NOT_FOUND);
          }
      } else {
          $error['message'] = 'Utente non registrato';
          return response()->json($error,Response::HTTP_BAD_REQUEST);
      }
  }

  public function updateRole(Request $request) {
      if(Auth::user()->role=='ADMIN' && $request->input('role') != 'ADMIN') {
          $changeRole = User::where('email', $request->input('email'))->first();
          if(is_null($changeRole)){
            $error = 'utente non trovato';
            return response()->json($error,Response::HTTP_NOT_FOUND);
          } else if($changeRole->role != 'ADMIN'){
              $changeRole->role = $request->input('role');
              $changeRole->update();
              $message['message'] = 'Il ruolo e\' stato aggiornato con sucesso in: '.$changeRole->role;
              return response()->json($message,Response::HTTP_OK);
          } else {
            $error = 'Non puoi cambiare il ruolo di questo utente';
            return rospose()->json($error,Response::HTTP_BAD_REQUEST);
          }
      } else {
          $error = 'Non si dispone dei permessi per effettuare questa operazione';
          return response()->json($error,Response::HTTP_BAD_REQUEST);
      }
  }

  public function remove() {
    if(Auth::user()->role=='ADMIN') {
        $changeRole = User::all()->find($request->input('id'));
        $changeRole->destroy();
        return response()->json(Response::HTTP_OK);
    } else {
        $error = 'non si dispone dei permessi per effettuare questa operazione';
        return response()->json($error, Response::HTTP_BAD_REQUEST);
    }
  }

  public function testAdmin() {
    $user = new User;
    $user->name = 'Giorno';
    $user->surname = 'Giovanna';
    $user->email = 'giogio@gmail.com';
    $user->password = app('hash')->make('password123');
    $user->role = 'ADMIN';
    $user->api_token = base64_encode(Str::random(60));

    $user->save();

    return response()->json($user,Response::HTTP_CREATED);

  }

  public function test(){

  }
}
