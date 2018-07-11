<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $table = 'post_meta';
    protected $primaryKey = 'meta_id';

    protected $guarded = [];

    public $timestamps = false;
}
