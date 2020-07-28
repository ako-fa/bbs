<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
         'name'
    ];

    /**
    * Postのcat_idを取得
    */
    public function posts()
    {
      // 投稿(Post)にはたくさんのコメント(Comments)がある
      return $this->hasMany('App\Post', 'cat_id');
    }
}
