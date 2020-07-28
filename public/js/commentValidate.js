$("#commentForm").validate({
    rules: {
        commenter: {
            required:   true,
            maxlength:  50
        },
        comment: {
            required:   true,
            maxlength:  2000
        },
    },
    messages: {
        commenter: {
            required:   "名前は必須です。",
            maxlength:  "名前は50文字以内で入力してください。"
        },
        comment: {
            required:   "コメントは必須です。",
            maxlength:  "コメントは2000文字以内で入力してください。"
        },
    }
});
