require('./testend-bootstrap');

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
