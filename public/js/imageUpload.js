$('.custom-file-input').on('change', handleFileSelect);

function handleFileSelect(e) {
    $('#preview').remove();
    $(this).parents('.input-group').after('<div id="preview"></div>');
    var file = e.target.files[0];
    var reader = new FileReader();

    reader.onload = (function(file) {
        return function(e) {
            if (file.type.match('image.*')) {
                var $html = [
                    '<div class="d-inline-block mr-1 mt-1"><img class="img-thumbnail" src="', e.target.result,'" title="', escape(file.name), '" style="height:200px;" /><div class="small text-muted text-center">', escape(file.name),'</div></div>'
                ].join('');// 画像では画像のプレビューとファイル名の表示
            } 
            $('#preview').append($html);
        };
    })(file);

    if (file) {
        reader.readAsDataURL(file);
        $(this).next('.custom-file-label').html($(this)[0].files[0].name + ' を選択しました');
    }
}

//ファイルの取消
$('.reset').click(function(){
    $(this).parent().prev().children('.custom-file-label').html('ファイル選択...');
    $('.custom-file-input').val('');
    $('#preview').remove('');
})
