//ページネーション
$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    
    let url = $(this).attr('href');
    let postID = $('#comment-pagination').data('post-id');

    var page = $(this).attr('href').split('page=')[1];
    $.ajax(
    {
        url: postID + '?page=' + page,
        type: "get",
        datatype: "html"
    })
    .done(function (response) {
        $('#comment-list').empty().html(response);
        location.hash = 'page=' + page;
        // location.search = 'page=' + page;
    })
    .fail(function (e) {
        alert('データの取得に失敗しました。');
    });
});
