import Swal from "sweetalert2";

const __ls_PreviousURLKey = "previous_url";

window.__debounce = function (func, wait, immediate) {
    var timeout;
    return function () {
        var context = this,
            args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

// window.__showNotification = function(type, message, timeout = 2500, layout = 'top') {
//     return new Noty({
//         theme: 'nest',
//         id: 'noty',
//         type: type,
//         layout: layout,
//         text: message,
//         timeout: timeout,
//         animation: {
//             open: 'animate__animated animate__fadeInDown animate__faster',
//             close: 'animate__animated animate__fadeOutUp animate__faster'
//         }
//     }).show();
// }

window.__cartItemCount = function () {
    axios
        .get("/cart/items/count")
        .then(function (response) {
            cartCount.text(response.data);
            if (cartCount.text() > 0) {
                $(".cart-dev").show();
            } else {
                $(".cart-dev").hide();
            }
        })
        .catch(function (error) {
            console.log(error);
        });
};

window.__savePreviousURL = function (url) {
    localStorage.setItem(__ls_PreviousURLKey, url);
};

window.__getPreviousURL = function () {
    return localStorage.getItem(__ls_PreviousURLKey);
};

window.__redirectPreviousURL = function () {
    const purl = __getPreviousURL();
    if (purl) {
        location.href = purl;
        localStorage.removeItem(__ls_PreviousURLKey);
    }
};

window.__showLoginNotification = function (
    type,
    message,
    timer = 10000,
    layout = "top-end"
) {
    const Toast = Swal.mixin({
        toast: true,
        position: layout,
        showConfirmButton: false,
        footer: '<a class="btn btn-sm btn-primary" href="/login">Login Here</a>',
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: type,
        title: message,
    });
};

window.__showNotification = function (
    type,
    message,
    timer = 5000,
    layout = "top-end"
) {
    Swal.fire({
        icon: type,
        title: message,
        // text: "Something went wrong!",
        // footer: '<a href="">Login Here</a>',
        // position: layout,
    });

    //     Swal.fire({
    //         title: "Custom width, padding, color, background.",
    //         width: 600,
    //         padding: "3em",
    //         color: "#716add",
    //         background: "#fff url(/images/trees.png)",
    //         backdrop: `
    //     rgba(0,0,123,0.4)
    //     url("/images/nyan-cat.gif")
    //     left top
    //     no-repeat
    //   `,
    //     });

    // const Toast = Swal.mixin({
    //     toast: true,
    //     position: layout,
    //     showConfirmButton: false,
    //     // footer: '<a class="btn btn-sm btn-primary" href="/login">Login Here</a>',
    //     timer: timer,
    //     timerProgressBar: true,
    //     didOpen: (toast) => {
    //         toast.addEventListener("mouseenter", Swal.stopTimer);
    //         toast.addEventListener("mouseleave", Swal.resumeTimer);
    //     },
    // });

    // Toast.fire({
    //     icon: type,
    //     title: message,
    // });
};
