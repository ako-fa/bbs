//ページネーション
$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();

    let categoryID = $('#category-pagination').data('category-id');
    console.dir(categoryID);

    var page = $(this).attr('href').split('page=')[1];
    $.ajax(
    {
        url: categoryID + '?page=' + page,
        type: "get",
        datatype: "html"
    })
    .done(function (response) {
        $('#category-list').empty().html(response);
        location.hash = 'page=' + page;
        // location.search = 'page=' + page;
    })
    .fail(function (e) {
        alert('データの取得に失敗しました。');
    });
});
