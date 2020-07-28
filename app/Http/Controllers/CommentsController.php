<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;

class CommentsController extends Controller
{
    //
    /**
    * コメント保存処理
    * @param Request $request
    * @param Post $post
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'commenter' => 'required|max:50',
            'comment' => 'required|max:2000',
        ],[
            'commenter.required' => '名前は必須です。',
            'commenter.max' => '名前は50文字以内で入力してください。',
            'comment.max' => 'コメントは2000文字以内で入力してください',
        ]);


        $comment = new Comment();
        $comment->commenter = $request->commenter;
        $comment->comment = $request->comment;
        $comment->post_id = $post->id;

        // dd($comment);

        $comment->save();

        return back()->with('c_create', 'コメントの投稿が完了しました。');
    }

    /**
    * 削除処理
    * @param Comment $comment
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    // public function destroy(Comment $comment)
    // {
    //     Comment::find($comment->id)->delete();
    //     return back()->with('c_delete', 'コメントの削除が完了しました。');
    // }

    /**
    * 削除処理
    * @param Comment $comment
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function destroy($comment_id)
    {
        // dd($comment_id);
        Comment::find($comment_id)->delete();

        $commentDelete = true;
        return response()->json(compact('commentDelete'));
        // return back()->with('c_delete', 'コメントの削除が完了しました。');
    }
}
