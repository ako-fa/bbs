@extends('layouts.default')

@if(isset($post))
    @section('jumbotron', 'Edit Article')
    @section('title', '編集 | LaravelのBBS')
@else
    @section('jumbotron', 'Create Article')
    @section('title', '新規作成 | LaravelのBBS')
@endif

@section('content')
<div class="col-2"></div>
<div class="col-8">
    <h1>投稿ページ</h1>
    <fieldset class="mb-4">
        @if(isset($post))
        {{-- 編集ボタンから来た場合 --}}
        <form id="editForm" class="" action="{{ route('update', $post) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
        @else
        {{-- 新規作成から来た場合 --}}
        <form id="createForm" class="" action="{{ route('store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        @endif

            {{-- トップ画像アップロードフォーム --}}
            <div class="form-group">
                <label for="top_image">トップ画像</label>
            	<div id="file" class="input-group">
            		<div class="custom-file">
                        <input id="top_image" class="custom-file-input {{ $errors->has('top_image') ? 'is-invalid' : ''}}" type="file" name="top_image" value="{{ isset($post) ? $post->top_image : old('top_image') }}">
            			<label class="custom-file-label" for="customfile" data-browse="参照">ファイル選択...</label>
            		</div>
            		<div class="input-group-append">
            			<button type="button" class="btn btn-outline-secondary reset">取消</button>
            		</div>
            	</div>
                @if(isset($post))
                <div id="preview" class="d-inline-block mr-1 mt-1">
                    <img class="img-thumbnail" src="{{ asset('storage/top_image/' . $post->top_image) }}" alt="" style="height:200px;"/>
                    <div class="small text-muted text-center">{{ $post->top_image }}</div>
                </div>
                @else
                <div id="preview" class="d-inline-block mr-1 mt-1">
                    <img class="img-thumbnail" src="{{ asset('storage/top_image/no-image.jpg') }}" alt="" style="height:200px;"/>
                    <div class="small text-muted text-center">no-image.jpg</div>
                </div>
                @endif

                <div class="{{ $errors->has('top_image') ? 'is-invalid' : '' }}"></div>
                @if ($errors->has('top_image'))
                <div class="invalid-feedback">{{ $errors->first('top_image') }}</div>
                @endif
            </div>

            {{-- タイトルフォーム --}}
            <div class="form-group mb-4">
                <label for="title">タイトル</label>
                <input id="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}" type="text" name="title" value="{{ isset($post) ? $post->title : old('title') }}">
                @if ($errors->has('title'))
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                @endif
            </div>

            {{-- カテゴリー選択 --}}
            <div class="form-group mb-4">
                <select class="form-control {{ $errors->has('cat_id') ? 'is-invalid' : ''}}" name="cat_id">
                    <option value="">カテゴリーを選択してください</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if(isset($post) && $post->cat_id == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('cat_id'))
                <div class="invalid-feedback">{{ $errors->first('cat_id') }}</div>
                @endif
            </div>

            {{-- 本文フォーム --}}
            <div class="form-group">
                <label for="content">本文</label>
                <textarea id="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : ''}}" name="content" rows="4">{{ isset($post) ? $post->content : old('content') }}</textarea>
                @if ($errors->has('content'))
                <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                @endif
            </div>

            @if (isset($post))
            {{-- 編集ボタンから来た場合 --}}
            <div class="mt-5">
                <input class="btn btn-warning submit" type="submit" value="編集する">
                <a class="btn btn-secondary" href="{{ route('show', $post) }}">キャンセル</a>
                <!-- <button class="btn btn-warning" type="submit">編集する</button> -->
            </div>
            @else
            {{-- 新規作成ボタンから来た場合 --}}
            <div class="mt-5">
                <input class="btn btn-primary submit" type="submit" value="投稿する">
                <a class="btn btn-secondary" href="{{ route('index') }}">キャンセル</a>
                <!-- <button class="btn btn-primary" type="submit">投稿する</button> -->
            </div>
            @endif
        </form>

    </fieldset>
</div>
<div class="col-2"></div>
@endsection

@section('createJS')
{{-- Validation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{ asset('js/postValidate.js') }}"></script>

{{-- 画像アップロード --}}
<script src="{{ asset('js/imageUpload.js') }}"></script>
@endsection
