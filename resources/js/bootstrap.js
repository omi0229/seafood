window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

import { createApp } from 'vue';
window.createApp = createApp;

window.Swal = require('sweetalert2');

// 驗證錯誤提示
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

// 密碼規則(8碼以上數字+英文)
export const passwordRule = password => {
    let rules = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (!rules.test(password)) {
        return false
    }

    return true;
}

// 電子郵件規則
export const emailRule = email => {
    let rules = /^([\w]+)(.[\w]+)*@([\w]+)(.[\w]{2,3}){1,2}$/;
    if (!rules.test(email)) {
        return false
    }

    return true;
}

// swal2 confirm
// 電子郵件規則
export const swal2Confirm = (title) => {
    return new Promise(resolve => {
        Swal.fire({
            title: title,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '確定',
            cancelButtonText: '取消',
            allowOutsideClick: false,
            confirmButtonClass: 'btn btn-sm btn-success px-3 ml-1',
            cancelButtonClass: 'btn btn-sm btn-danger px-3 mr-1',
            buttonsStyling: false,
            reverseButtons: true,
            padding: 30,
            width: 300,
        }).then((result) => {
            if (result.isConfirmed) {
                resolve(true);
            }

            resolve(false);
        })
    });
}

