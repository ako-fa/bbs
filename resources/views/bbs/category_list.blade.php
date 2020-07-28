<div class="row">
    @foreach ($category_posts as $category_post)
    <div class="col-4 py-3">
        <div class="p-3 shadow-sm">
            <h2 class="line-2_title">{{ str_limit($category_post->title, 40) }}</h2>

            <ul class="list-group list-group-horizontal">
                <li class="list-group-item flex-fill py-1">
                    <span class="small"><i class="far fa-clock"></i> {{ date("Y年 m月 d日", strtotime($category_post->created_at)) }}</span>
                </li>
                <li class="list-group-item flex-fill py-1">
                    <span class="small"><i class="fas fa-clipboard-list"></i> <a href="{{ route('category', $category_post->category->id) }}">{{ $category_post->category->name }}</a></span>
                </li>
            </ul>

            <p class="line-3_content">{!! nl2br(e(str_limit($category_post->content, 140))) !!}</p>

            <ul class="list-group" style="max-width: 400px;">
                <li class="list-group-item d-flex justify-content-between align-items-center py-1 mb-3">
                    コメント数
                    <span class="badge badge-primary badge-pill">{{ $category_post->comment_count }}</span>
                </li>
            </ul>

            <a class="btn btn-primary" href="{{ action('PostsController@show', $category_post->id) }}">続きを読む</a>
        </div>
    </div>
    @endforeach
</div>

<div id="category-pagination" class="d-flex justify-content-center mt-3" data-category-id="{{ $id }}">
    {{ $category_posts->links() }}
</div>
