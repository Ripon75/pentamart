$(function() {
    $('*[data-mc-on-previous-url]').on('click', function($event) {
        const url = $(this).data('mc-on-previous-url');
        __savePreviousURL(url);
    });
});
