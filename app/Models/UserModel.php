<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
  use SoftDeletes;
  protected $table = 'users';
  protected $fillable = ['name','username','password','address'];
  protected $hidden = ['username','password','remember_token','deleted_at'];

  public $timestamps = false;

  public function posts()
  {
    return $this->hasMany('App\Models\PostModel','user_id');
  }

  public function rules($id=null){
    if ($id) {
      return [
        'name'=>'required|string|min:3',
        'username'=>'required|string|min:6|unique:users,username,'.$id,
        'password'=>'required|string|min:6'
      ];
    }
    return [
      'name'=>'required|string|min:3',
      'username'=>'required|string|min:6|unique:users',
      'password'=>'required|string|min:6'
    ];
  }
}
