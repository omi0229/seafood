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

// 頁面讀取中樣式
import 'load-awesome/css/ball-scale-ripple.css';
window.loading = createApp({
    data() {
        return {
            show: true,
        }
    },
}).mount('#loading');

// 密碼規則(8碼以上數字+英文)
export const passwordRule = password => {
    let rules = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (!rules.test(password)) {
        return false
    }

    return true;
}

export const emailRule = email => {
    let rules = /^([\w]+)(.[\w]+)*@([\w]+)(.[\w]{2,3}){1,2}$/;
    if (!rules.test(email)) {
        return false
    }

    return true;
}

