<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostModel extends Model
{
  use SoftDeletes;
  protected $table = 'post';
  protected $fillable = ['title','content','slug','status'];
  protected $hidden = ['user_id','deleted_at'];

  public $rules = ['title'=>'required|string'];

  public function author()
  {
    return $this->belongsTo('App\Models\UserModel','user_id');
  }
}
