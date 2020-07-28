<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Post;
use App\Category;

class PostsController extends Controller
{
    public function __construct() {
        $this->countCommtents();
        // $this->commentRank();
    }

    /**
    * 投稿一覧ページの表示
    * @param Request $request
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function index(Request $request)
    {
        //検索用
        $keyword = $request->input('keyword');
        $query = Post::query();

        $ranks = $this->commentRank();

        if(!empty($keyword)) {
            // 検索するテキストが入力されている場合
            $posts = $query->where('title', 'like', '%'.$keyword.'%')->paginate(6);
        } else {
            // 検索するテキストが未入力の場合
            $posts = Post::with('comments')->latest()->paginate(6);
        }


        // 記事の一覧表示をAjaxで表示するための処理
        if ($request->ajax()) {
            return response()->view('bbs.list', compact('posts', 'keyword'));
        }

        return view('bbs.index', compact('posts', 'ranks', 'keyword'));
    }

    /**
    * 詳細ページの表示
    * @param Request $request
    * @param Post $post
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Post $post)
    {
        $post = Post::with('comments')->find($post->id);
        $ranks = $this->commentRank();
        $comments = $post->comments()->paginate(10);

        // コメントの一覧表示をAjaxで表示するための処理
        if ($request->ajax()) {
            return response()->view('bbs.comment_list', compact('post', 'comments'));
        }

        return view('bbs.single', compact('post', 'comments', 'ranks'));
    }

    /**
    * 新規投稿ページの表示
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function create()
    {
        $categories = Category::all();
        return view('bbs.create')->with('categories', $categories);
    }

    /**
    * 新規投稿処理
    * @param Request $request
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|max:50',
            'cat_id'    => 'required',
            'content'   => 'required|max:2000',
            'top_image'   => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'title.required'    => 'タイトルは必須です。',
            'title.max'         => 'タイトルは50文字以内で入力してください。',
            'cat_id.required'   => 'カテゴリー選択は必須です。',
            'content.required'  => '本文は必須です。',
            'content.max'       => '名前は2000文字以内で入力してください',
            'top_image.image'   => 'トップ画像には画像ファイルを指定してください',
            'top_image.mimes'   => 'トップ画像にはjpeg,png,jpg,gifのいずれかの形式のファイルを指定してください',
        ]);

        // dd($request->top_image);

        // dd($request->title, $request->cat_id, $request->content);
        // Post::create($params);


        $post = new Post();
        $post->title = $request->title;
        $post->cat_id = $request->cat_id;
        $post->content = $request->content;

        if(empty($request->top_image)) {
            $post->top_image = null;
        } else {
            $filename = $request->top_image->store('public/top_image');
            $post->top_image = basename($filename);
        }

        $post->comment_count = 0;
        $post->save();

        return redirect()->route('index')->with('create', '投稿が完了しました。');
    }

    /**
    * 編集ページの表示
    * @param Post $post
    * @return \Illuminate\Routing\Redirector
    */
    public function edit(Post $post)
    {
        // dd($post);
        $categories = Category::all();
        return view('bbs.create', compact('post', 'categories'));
    }

    /**
    * 編集処理
    * @param Request $request
    * @param Post $post
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:50',
            'cat_id' => 'required',
            'content' => 'required|max:2000',
            'top_image'   => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは50文字以内で入力してください。',
            'cat_id.required' => 'カテゴリー選択は必須です。',
            'content.required' => '本文は必須です。',
            'content.max' => '名前は2000文字以内で入力してください',
            'top_image.image'   => 'トップ画像には画像ファイルを指定してください',
            'top_image.mimes'   => 'トップ画像にはjpeg,png,jpg,gifのいずれかの形式のファイルを指定してください',
        ]);

        if(!empty($request->top_image)) {
            $filename = $request->top_image->store('public/top_image');
            $post->top_image = basename($filename);
        } else {
            $post->top_image = $post->top_image;
        }

        $post->title = $request->title;
        $post->cat_id = $request->cat_id;
        $post->content = $request->content;
        $post->save();

        return redirect()->route('show', $post)->with('update', '編集が完了しました。');
    }

    /**
    * 削除処理
    * @param Post $post
    * @return \Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse
    */
    public function destroy(Post $post)
    {
        Post::find($post->id)->comments()->delete();
        Post::find($post->id)->delete();
        return redirect()->route('index')->with('delete', '削除が完了しました。');
    }

    /**
    * カテゴリーページ情報を送る
    * @param int $id
    * @param Request $request
    * @return \Illuminate\Routing\Redirector
    */
    public function showCategory($id, Request $request)
    {
        $category_posts = Post::with('comments')->latest()->where('cat_id', $id)->paginate(6);
        $category_name = Category::where('id', $id)->get();
        $category_name->toArray();

        // カテゴリーの一覧表示をAjaxで表示するための処理
        if ($request->ajax()) {
            return response()->view('bbs.category_list', compact('category_posts', 'id'));
        }

        return view('bbs.category', compact('category_posts', 'category_name', 'id'));
    }

    /**
    * コメント件数の計算
    * seederでコメント数の初期値を設定できなかったため仕方ない処理
    * 記事件数とその記事へのコメント数が増えるほど処理に時間がかかる
    * ログでSQL確認済み
    */
    public function countCommtents()
    {
        $users = Post::whereNull('deleted_at')->get();
        foreach($users as $user) {
            $user->comment_count = $user->comments()->count();
            $user->save();
        }
    }

    /**
    * コメント件数の多い順に5件取得
    */
    public function commentRank()
    {
        return Post::orderBy('comment_count', 'desc')->take(5)->get();
        // dd($ranks);
        // return view('layouts.default', compact('ranks'));
    }

}
