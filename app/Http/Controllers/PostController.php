<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostModel;
use App\Models\UserModel;

use Validator;

class PostController extends Controller
{
    public function __construct(Request $request)
    {
      $this->post = new PostModel;
      $this->user = UserModel::where('remember_token',$request->header('_token'))->first();
    }

    public function all()
    {
      $data = $this->post->all();
      if (!count($data)) {
        return $this->responseError('Data tidak tersedia');
      }
      foreach ($data as $key => $v) {
        $data[$key]->author;
      }
      return $this->responseSuccess($data);
    }

    public function show($id)
    {
      $data = $this->post->find($id);
      if (!count($data)) {
        return $this->responseError("Data dengan id {$id} tidak ditemukan");
      }
      $data->author;
      return $this->responseSuccess($data);
    }

    public function add(Request $request)
    {
      $cek = $this->validateInput($request,$this->post->rules);
      if ($cek->fails()) {
        return $this->responseError($cek->errors(),422);
      }
      $this->post->user_id = $this->user->id;
      $this->post->title = $request->input('title');
      $this->post->content = $request->input('content');
      $this->post->slug = str_slug($request->input('title'),'-');
      $this->post->status = $request->input('status');
      if ($this->post->save()) {
        return $this->responseSuccess($this->post,201);
      }
      return $this->responseError('Proses input bermasalah',503);
    }

    public function update(Request $request,$id)
    {
      $post = $this->post->find($id);
      if (!count($post)) {
        return $this->responseError("Data dengan id {$id} tidak ditemukan");
      }
      $cek = $this->validateInput($request,$this->post->rules);
      if ($cek->fails()) {
        return $this->responseError($cek->errors(),422);
      }
      $post->user_id = $this->user->id;
      $post->title = $request->input('title');
      $post->content = $request->input('content');
      $post->slug = str_slug($request->input('title'),'-');
      $post->status = $request->input('status');
      if ($post->save()) {
        return $this->responseSuccess($post,201);
      }
      return $this->responseError('Proses input bermasalah',503);
    }
    public function delete(Request $request,$id)
    {
      $post = $this->post->find($id);
      if (!count($post)) {
        return $this->responseError("Data dengan id {$id} tidak ditemukan");
      }
      if ($post->delete()) {
        return $this->responseSuccess($post,201);
      }
      return $this->responseError('Proses input bermasalah',503);
    }

    public function validateInput(Request $request,$rules)
    {
      return Validator::make($request->all(),$rules,[
        'required'=>':Attribute tidak boleh kosong'
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
