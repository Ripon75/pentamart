require('./adminend-bootstrap');
require('tw-elements');

window.__debounce = function (func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}


window.__showNotification = function(type, message, timeout = 2500, layout = 'top') {
    return new Noty({
        theme: 'nest',
        id: 'noty',
        type: type,
        layout: layout,
        text: message,
        timeout: timeout,
        animation: {
            open: 'animate__animated animate__fadeInDown animate__faster',
            close: 'animate__animated animate__fadeOutUp animate__faster'
        }
    }).show();
}
