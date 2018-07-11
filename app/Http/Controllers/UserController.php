<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Validator;

class UserController extends Controller
{

  public function __construct()
  {
    $this->user = new UserModel;
  }

  public function all()
  {
    $data = $this->user->all();
    if (!count($data)) {
      return $this->responseError('Data tidak tersedia');
    }
    return $this->responseSuccess($data);
  }

  public function show($id)
  {
    $data = $this->user->find($id);
    if (!count($data)) {
      return $this->responseError("Data dengan id {$id} tidak ditemukan");
    }
    return $this->responseSuccess($data);
  }
  public function post($id)
  {
    $data = $this->user->find($id);
    if (!count($data)) {
      return $this->responseError("Data dengan id {$id} tidak ditemukan");
    }
    $data->posts;
    return $this->responseSuccess($data);
  }

  public function add(Request $request)
  {
    $cek = $this->validateInput($request,$this->user->rules());
    if ($cek->fails()) {
      return $this->responseError($cek->errors(),422);
    }
    $this->user->name = $request->input('name');
    $this->user->username = $request->input('username');
    $this->user->password = app('hash')->make($request->input('password'));
    $this->user->address = $request->input('address');
    if ($this->user->save()) {
      return $this->responseSuccess($this->user,201);
    }
    return $this->responseError('Proses input bermasalah',503);
  }

  public function update(Request $request,$id)
  {
    $user = $this->user->find($id);
    if (!count($user)) {
      return $this->responseError("Data dengan id {$id} tidak ditemukan");
    }
    $cek = $this->validateInput($request,$this->user->rules($id));
    if ($cek->fails()) {
      return $this->responseError($cek->errors(),422);
    }
    $user->name = $request->input('name');
    $user->username = $request->input('username');
    $user->password = app('hash')->make($request->input('password'));
    $user->address = $request->input('address');
    if ($user->save()) {
      return $this->responseSuccess($user,201);
    }
    return $this->responseError('Proses input bermasalah',503);
  }
  public function delete(Request $request,$id)
  {
    $user = $this->user->find($id);
    if (!count($user)) {
      return $this->responseError("Data dengan id {$id} tidak ditemukan");
    }
    if ($user->remember_token == $request->header('_token')) {
      return $this->responseError("Anda tidak dapat menghapus akun yang sedang aktif",403);
    }
    if ($user->delete()) {
      return $this->responseSuccess($user,201);
    }
    return $this->responseError('Proses input bermasalah',503);
  }

  public function login(Request $request)
  {
    $cek = $this->validateInput($request,[
      'username'=>'required|string',
      'password'=>'required|string'
    ]);
    if ($cek->fails()) {
      return $this->responseError($cek->errors(),422);
    }
    $login = $this->user->where('username',$request->input('username'))->first();
    if (!count($login)) {
      return $this->responseError("Username atau password tidak benar",401);
    }
    if (!app('hash')->check($request->input('password'),$login->password)) {
      return $this->responseError("Username atau password tidak benar",401);
    }
    $token = base64_encode(str_random(40));
    $login->remember_token = $token;
    $login->save();
    $login['api_token'] = $token;
    return $this->responseSuccess($login,201);
  }

  public function validateInput(Request $request,$rules)
  {
    return Validator::make($request->all(),$rules,[
      'required'=>':Attribute tidak boleh kosong',
      'min'=>'Panjang karakter :attribute minimal :min',
      'unique'=>':Attribute telah digunakan'
    ]);
  }


  public function responseSuccess($data,$code=200)
  {
    return response()->json(['status'=>'success','data'=>$data],$code);
  }

  public function responseError($msg,$code=404)
  {
    return response()->json(['status'=>'error','message'=>$msg],$code);
  }

}
