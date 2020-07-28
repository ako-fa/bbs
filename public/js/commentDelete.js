/* エラー文字列の生成 */
function errorHandler(args) {
    var error;
    // errorThrownはHTTP通信に成功したときだけ空文字列以外の値が定義される
    if (args[2]) {
        try {
            // JSONとしてパースが成功し、且つ {"error":"..."} という構造であったとき
            // (undefinedが代入されるのを防ぐためにtoStringメソッドを使用)
            error = JSON.parse(args[0].responseText).error.toString();
        } catch (e) {
            // パースに失敗した、もしくは期待する構造でなかったとき
            // (PHP側にエラーがあったときにもデバッグしやすいようにレスポンスをテキストとして返す)
            error = 'parsererror(' + args[2] + '): ' + args[0].responseText;
        }
    } else {
        // 通信に失敗したとき
        error = args[1] + '(HTTP request failed)';
    }
    return error;
}

$(function() {
    $(document).on('click', '#commentDeleteButton', function () {
        var deleteConfirm = confirm('削除してよろしいでしょうか？');

        if(deleteConfirm == true) {
            var clickEle = $(this)
            // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
            var commentID = clickEle.attr('data-comment-id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/comment/delete/' + commentID,
                type: 'POST',
                dataType: 'json',
                data: {
                    'comment_id': commentID,
                    '_method'   : 'DELETE'  // DELETE リクエストだよ！と教えてあげる。
                },
            })

            .done(function(response) {
                // 通信が成功した場合、クリックした要素の先祖要素の <li> を削除
                if(response.commentDelete == true) {
                    $('#alertCommentDelete').show();
                    clickEle.parents('.comment-list').hide('fast', function() {
                        clickEle.parents('.comment-list').remove();
                    });

                    setTimeout(function(){
                        $("html,body").animate({scrollTop:$('#comment-list-top').offset().top});
                    }, 300);
                }
            })

            .fail(function() {
                alert(errorHandler(arguments));
            });

        } else {
            (function(e) {
                e.preventDefault()
            });
        };
    });
});

$(function() {
    $('#alertCommentDeleteButton').on('click', function () {
        console.dir('true');
        $('#alertCommentDelete').hide('fast');
    });
});
