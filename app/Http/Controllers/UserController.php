<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  private $rules;
  public function __construct()
  {
    $this->rules = [
      'name' => 'required|string',
      'email' => 'required|email|unique:users',
      'password' => 'required'
    ];
  }

  public function index(){
    try {
      return User::get();
    } catch (\Throwable $th) {
      return \response()->json([
        'status' => false,
        'message' => 'Não foi possível processar o seu pedido.'
      ]);
    }
  }

  public function show($id){
    try {
      return User::findOrFail($id);
    } catch (\Throwable $th) {
      return \response()->json([
        'status' => false,
        'message' => 'Não foi possível processar o seu pedido.'
      ]);
    }
  }

  public function register(Request $req){
    try {

      $validator = Validator::make($req->all(), $this->rules, [
        'required' => 'O campo :attribute é obrigatório',
        'unique' => 'Este :attribute já está a ser utilizado',
        'email' => 'Email inválido'
      ]);

      if($validator->fails()){
        return \response()->json($validator->getMessageBag());
      }

      return User::create($validator->validated());

    } catch (\Throwable $th) {
      return \response()->json([
        'status' => false,
        'message' => 'Não foi possível processar o seu pedido.'
      ]);
    }
  }

  public function update(Request $req){
    try {
      $user = User::findOrFail($req->id);
      if(!$user){
        return \response()->json([
          'status' => false,
          'message' => 'Usuário não encontrado.'
        ]);
      }

      $update = User::where("id", $req->id)->update([
        'name' => $req->name,
        'email' => $req->email
      ]);

      return $user->refresh();

    } catch (\Throwable $th) {
      return \response()->json([
        'status' => false,
        'message' => 'Não foi possível processar o seu pedido.'
      ]);
    }
  }

  public function delete($id){
    try {
     $delete = User::destroy([$id]);

     return \response()->json([
      'status' => true,
      'message' => 'Usuário eliminado com sucesso.'
    ]);

    } catch (\Throwable $th) {
      return \response()->json([
        'status' => false,
        'message' => 'Não foi possível processar o seu pedido.'
      ]);
    }
  }
}
