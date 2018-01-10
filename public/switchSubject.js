$('#subjectFilter>button').click(function (event) {
    $('#subjectFilter>button').removeClass('disabled');
    $(event.currentTarget).addClass('disabled');

    var clickedId = event.currentTarget.id;

    switch(clickedId){
        case "allSubject":
            $('.subject').show();
            break;
        case "mySubjects":
            $('.mySubject').show();
            $('.notMySubject').hide();
            break;
        case "unassignedSubjects":
            $('.notMySubject').show();
            $('.mySubject').hide();
            break;
    }
});