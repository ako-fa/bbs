<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use softDeletes;
    protected $table = 'posts';
    protected $dates = ['deleted_at'];

    protected $fillable = [
         'title',
         'content'
      ];

    /**
     * PostのCommentを取得
     */
    public function comments()
    {
        // 投稿(Post)にはたくさんのコメント(Comments)がある
        return $this->hasMany('App\Comment', 'post_id');
    }

    /**
     * このPostを所有するCategoryを取得
     */
    public function category()
    {
        // 投稿(Post)は1つのカテゴリー(Category)に属する
        return $this->belongsTo('App\Category', 'cat_id');
    }
}
