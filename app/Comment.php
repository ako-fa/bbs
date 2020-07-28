<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use softDeletes;
    protected $table = 'comments';
    protected $dates = ['deleted_at'];

    protected $fillable = [
         'commenter', 'comment'
      ];

    /**
    * このPostを所有するPostを取得
    */
    public function post()
    {
        // コメント(Comment)は1つの投稿(Post)に属する
        return $this->belongsTo('App\Post', 'post_id');
    }
}
