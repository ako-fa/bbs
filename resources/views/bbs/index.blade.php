@extends('layouts.default')

@section('jumbotron', 'BBS List')
@section('title', '記事一覧 | LaravelのBBS')

{{-- ランキング --}}
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


{{-- 記事一覧 --}}
@section('content')
<div class="col-lg-9 pl-5">
    <div class="row">
        <div class="col-12">
            <div class="d-inline-block">
                <h1 class="mb-2 ">新着記事</h1>
            </div>

            {{-- 検索機能 --}}
            <fieldset class="float-right">
                <form id="searchForm" class="form-inline" action="{{ route('index') }}" method="get">


                    {{-- 検索フォーム --}}
                    <input id="keyword" class="form-control mb-2 mr-sm-2 mb-sm-0" type="text" name="keyword" value="{{ $keyword or '' }}" placeholder="タイトル検索" data-keyword="{{ $keyword }}">

                    {{-- 検索ボタン --}}
                    <button type="search" class="btn btn-secondary"><i class="fas fa-search fa-fw"></i>検索</button>
                </form>
            </fieldset>
        </div>
    </div>

    {{-- 投稿完了時にフラッシュメッセージを表示 --}}
    @if (session('create'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('create') }}
            </div>
        </div>
    </div>
    @endif

    {{-- 削除時にフラッシュメッセージを表示 --}}
    @if (session('delete'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('delete') }}
            </div>
        </div>
    </div>
    @endif

    {{-- 記事リスト --}}
    <div id="article-list">
        @include('bbs.list')
    </div>

</div>

<hr>
@endsection

@section('indexJS')
<script <script src="{{ asset('js/indexPagination.js') }}"></script>
@endsection
