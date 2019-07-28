let pageIndex = 0;

const pages = $('.page');

const nextButton = $('#next-btn');
const previousButton = $('#previous-btn');
const submitButton = $('#submit-btn');

const changePage = function(){
    pages.addClass('d-none');
    const page = $(pages.get(pageIndex));
    page.removeClass('d-none');

    if (pageIndex === 0) {
        previousButton.addClass('d-none')
    }else{
        previousButton.removeClass('d-none')
    }

    if (pageIndex === pages.length - 1) {
        nextButton.addClass('d-none');
        submitButton.removeClass('d-none')
    }else{
        nextButton.removeClass('d-none');
        submitButton.addClass('d-none')
    }
};


nextButton.on('click', function(event){
    pageIndex++;
    changePage();
    event.preventDefault();
    return false;
});

previousButton.on('click', function(event){
    pageIndex--;
    changePage();
    event.preventDefault();
    return false;
});


changePage();

$('#APP_URL').val(location.origin);