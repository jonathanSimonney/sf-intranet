$('#userFilter>button').click(function (event) {
    $('#userFilter>button').removeClass('disabled');
    $(event.currentTarget).addClass('disabled');

    var clickedId = event.currentTarget.id;
    $('.user').show();

    switch(clickedId){
        case "allUsers":
            break;
        case "student":
            $('.user:not(.ROLE_USER)').hide();
            break;
        case "teacher":
            $('.user:not(.ROLE_TEACHER)').hide();
            break;
        case "admin":
            $('.user:not(.ROLE_ADMIN)').hide();
            break;
    }
});