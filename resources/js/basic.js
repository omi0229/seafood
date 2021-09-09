window.app = createApp({
    data() {
        return {
            config: {
                web_title: '',
                web_phone: '',
                web_address: '',
                web_email: '',
                web_facebook: '',
                web_line: '',
                meta_keyword: '',
                meta_description: '',
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        setTimeout(function () {
            loading.show = false;
        }, 1)
    },
    methods: {

    },
}).mount('#app');
