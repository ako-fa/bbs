//ページネーション
$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var keyword = $('#keyword').attr("data-keyword")
    if(keyword) {
        // 検索(keywordに値がある)時のURI
        url = 'bbs?keyword=' + keyword + '&page=' + page;
    } else {
        // 通常のURI
        url = 'bbs?page=' + page;
    }

    $.ajax(
    {
        url: url,
        type: "get",
        datatype: "html"
    })
    .done(function (response) {
        $('#article-list').empty().html(response);
        location.hash = 'page=' + page;
        // location.search = 'page=' + page;
    })
    .fail(function (e) {
        alert('データの取得に失敗しました。');
    });
});
