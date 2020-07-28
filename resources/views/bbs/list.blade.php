<div class="row">
    @foreach($posts as $post)
    <div class="col-md-6 mb-3">
        <div class="p-3 shadow-sm">

            {{-- <h2 class="line-2_title">{{ $post->title }}</h2> --}}

            <h2 class="line-2_title">{{ str_limit($post->title, 18) }}</h2>

            <ul class="list-group list-group-horizontal mb-3">
                <li class="list-group-item flex-fill py-1">
                    <span class="small"><i class="far fa-clock"></i> {{ date("Y年 m月 d日", strtotime($post->created_at)) }}</span>
                </li>
                <li class="list-group-item flex-fill py-1">
                    <span class="small"><i class="fas fa-clipboard-list"></i> <a href="{{ route('category', $post->category->id) }}">{{ $post->category->name }}</a></span>
                </li>
            </ul>

            {{-- トップ画像 --}}
            @if(isset($post->top_image))
            <div class="item">
                <div class="thumbnail">
                    <div class="inner">
                        <img src="{{ asset('storage/top_image/' . $post->top_image) }}" alt="" class="image" />
                    </div>
                </div>
            </div>

            @else
            <img src="{{ asset('storage/top_image/no-image.jpg') }}" alt="" class="img-fluid" style="width:100%;"/>
            @endif

            <p class="line-3_content mt-3">{!! nl2br(e(str_limit($post->content, 40))) !!}</p>

            <ul class="list-group" style="max-width: 400px;">
                <li class="list-group-item d-flex justify-content-between align-items-center py-1 mb-3">
                    コメント数
                    <span class="badge badge-primary badge-pill">{{ $post->comment_count }}</span>
                </li>
            </ul>

            <a class="btn btn-primary" href="{{ action('PostsController@show', $post->id) }}">続きを読む</a>

        </div>
    </div>
    @endforeach

</div>

{{-- ページネーションの表示 --}}
<div class="d-flex justify-content-center mt-3">
    {{ $posts->appends(Request::only('keyword'))->links() }}
</div>
