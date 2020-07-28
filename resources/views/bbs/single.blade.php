@extends('layouts.default')

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('jumbotron', 'BBS Article')
@section('title', '記事詳細 | LaravelのBBS')

{{-- ランキングパーツ --}}
@section('ranking')
<div class="ranking col-lg-3 mb-5">
    <div class="">
        <h2 class="ranking-title text-center">コメント数ランキング</h2>
    </div>
    <div class="list-group">
        <?php $i = 1; ?>
        @foreach ($ranks as $rank)
        <a href="{{ action('PostsController@show', $rank->id) }}" class="list-group-item list-group-item-action rank-list">
            {{-- ランキングNo. --}}
            <div class="d-inline-block float-left rank-number">
                <span><?php echo $i++; ?></span>
            </div>
            {{-- ランキング内容 --}}
            <div class="rank-article">
                <div class="d-inline-block">
                    <h3 class="rank-article-title">{{ $rank->title }}</h3>
                </div>
                <div class="d-inline-block rank-article-meta">
                    <span class="">{{ date("Y年 m月 d日", strtotime($rank->created_at)) }}</span>
                    <span class="badge badge-primary badge-pill">{{ $rank->comment_count }}</span>
                </div>
                <div class="clear-flex rank-date">
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-9">
    {{-- 投稿編集時にフラッシュメッセージを表示 --}}
    @if (session('update'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('update') }}
    </div>
    @endif

    {{-- コメント投稿完了時にフラッシュメッセージを表示 --}}
    @if (session('c_create'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('c_create') }}
    </div>
    @endif

    {{-- 投稿詳細 --}}
    <div class="row">
        <div class="col-12">
            {{-- 編集・削除ボタン --}}
            <div class="mb-4 text-right">
                <a class="btn btn-primary" href="{{ route('edit', $post) }}">編集する</a>
                <form id="articleDelete" style="display: inline-block;" action="{{ route('delete', $post) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#articleDeleteModal">削除する</button>
                </form>
            </div>

            {{-- タイトル --}}
            <h2>{{ $post->title }}</h2>
            <ul class="list-group list-group-horizontal my-3">
                <li class="list-group-item flex-fill py-1">
                    <span class="small">投稿日：{{ date("Y年 m月 d日", strtotime($post->created_at)) }}</span>
                </li>
                <li class="list-group-item flex-fill py-1">
                    <span class="small">カテゴリー：{{ $post->category->name }}</span>
                </li>
            </ul>

            {{-- トップ画像 --}}
            @if(isset($post->top_image))
            <img src="{{ asset('storage/top_image/' . $post->top_image) }}" alt="" class="img-fluid" style="width:100%;"/>
            @else
            <img src="{{ asset('storage/top_image/no-image.jpg') }}" alt="" class="img-fluid" style="width:100%;"/>
            @endif

            {{-- 本文 --}}
            <p class="my-3">{!! nl2br(e($post->content)) !!}</p>
        </div>
    </div>

    {{-- モーダル --}}
    <div class="modal fade" id="articleDeleteModal" tabindex="-1" role="dialog" aria-labelledby="articleDeleteTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="articleDeleteTitle">記事の削除</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><span>{{ $post->title }}</span>の記事を削除しますか？</p>
                </div>
                <div class="modal-footer">
                    <button id="articleDeleteButton" type="button" class="btn btn-danger">削除する</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    <hr>

    {{-- コメント --}}
    <div id="comment-list-top" class="row">

        <div class="col-12">
            <h3 class="my-4">コメント一覧</h3>
        </div>

        {{-- コメント削除完了時にメッセージを表示 --}}
        <div class="col-12">
            <div id="alertCommentDelete" class="alert alert-danger alert-dismissible" style="display:none;">
                <button id="alertCommentDeleteButton" type="button" class="close">&times;</button>
                コメントを削除しました。
            </div>
        </div>

        {{-- コメントリスト --}}
        <div id="comment-list" class="col-12">
            @include('bbs.comment_list')
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-12">
            <h3 class="mt-4">コメントを投稿する</h3>

            {{-- コメント投稿 --}}
            <fieldset class="my-5">
                <form id="commentForm" action="{{ route('c_store', $post) }}" method="post">
                    {{ csrf_field() }}

                    {{-- コメンターフォーム --}}
                    <div class="form-group mb-4">
                        <label for="commenter">名前</label>
                        <input id="commenter" class="form-control {{ $errors->has('commenter') ? 'is-invalid' : ''}}" type="text" name="commenter" value="{{ old('commenter') }}">
                        @if ($errors->has('commenter'))
                        <div class="invalid-feedback">
                            {{ $errors->first('commenter') }}
                        </div>
                        @endif
                    </div>

                    {{-- コメントフォーム --}}
                    <div class="form-group">
                        <label for="comment">コメント</label>
                        <textarea id="comment" class="form-control {{ $errors->has('comment') ? 'is-invalid' : ''}}" name="comment" rows="4">{{ old('comment') }}</textarea>
                        @if ($errors->has('comment'))
                        <div class="invalid-feedback">
                            {{ $errors->first('comment') }}
                        </div>
                        @endif
                    </div>

                    {{-- コメント投稿ボタン --}}
                    <div class="mt-5 text-center">
                        <input class="btn btn-primary submit" type="submit" value="投稿する">
                    </div>
                </form>
            </fieldset>

        </div>
    </div>
</div>
@endsection

@section('singleJS')
<!-- Modal by Bootstrap4 -->
<script src="{{ asset('js/articleDeleteModal.js') }}"></script>
<!-- jQueryCommentDelete -->
<script src="{{ asset('js/commentDelete.js') }}"></script>
<!-- jQueryValidate -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
<script src="{{ asset('js/commentValidate.js') }}"></script>
<script src="{{ asset('js/singleCommentPagination.js') }}"></script>
@endsection
