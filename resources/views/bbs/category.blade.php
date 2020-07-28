@extends('layouts.default')

@section('jumbotron', 'Category')
@section('title', 'カテゴリー | LaravelのBBS')

@section('content')
<div class="container mt-5">
    <h1>カテゴリ : {{ $category_name[0]['name'] }} のページ</h1>

    <div id="category-list" class="">
        @include('bbs.category_list')
    </div>

</div>
@endsection

@section('categoryJS')
<script <script src="{{ asset('js/categoryPagination.js') }}"></script>
@endsection
