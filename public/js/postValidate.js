$("#createForm,#editForm").validate({
    rules: {
        title: {
            required:   true,
            maxlength:  50
        },
        cat_id: {
            required:   true,
        },
        content: {
            required:   true,
            maxlength:  2000
        },
        top_image: {
            accept:     "image/*",
            extension:  "gif|jpeg|jpg|png",
        },
    },
    messages: {
        title: {
            required:   "タイトルは必須です。",
            maxlength:  "タイトルは50文字以内で入力してください。"
        },
        cat_id: {
            required:   "カテゴリー選択は必須です。",
        },
        content: {
            required:   "本文は必須です。",
            maxlength:  "本文は2000文字以内で入力してください。"
        },
        top_image: {
            accept:     "トップ画像には画像ファイルを指定してください",
            extension:  "トップ画像にはjpeg,jpg,png,gifのいずれかの形式のファイルを指定してください",
        },
    },
    errorPlacement: function (err, element) {
        console.dir(element);
        if (element.attr("name") == "top_image") {
            $('#file').after(err);
        } else {
            element.after(err);
        }
    },
});
