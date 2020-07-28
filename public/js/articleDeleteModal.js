$('#articleDeleteModal').on('shown.bs.modal', function () {
    $('#articleDeleteButton').on('click', function (){
        $('#articleDelete').submit();
    });
});
