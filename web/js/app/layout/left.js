function goPage(event) {
    var a = $(event.target);
    var url = a.attr('href');
    $('section.content').load(url);
    event.preventDefault();
}


$(document).ready(function () {
    $('.menu').on('click', 'a', function (event) {
        goPage(event);
        return false;
    });
});