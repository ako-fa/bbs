<div class="row">
    @foreach($comments as $comment)
    <div class="col-12 comment-list">
        <ul class="list-group mb-3">
            <li class="list-group-item">
                <h4 class="float-left">{{ $comment->commenter }}</h4>
                <form class="float-right" action="{{ route('c_delete', $comment) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button id="commentDeleteButton" class="close" type="button" aria-label="閉じる" data-comment-id="{{ $comment->id }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </form>
            </li>
            <li class="list-group-item">
                <p>{!! nl2br(e($comment->comment)) !!}</p>
            </li>
        </ul>
    </div>
    @endforeach
</div>

<div id="comment-pagination" class="d-flex justify-content-center mt-3" data-post-id="{{ $post->id }}">
    {{ $comments->links() }}
</div>
