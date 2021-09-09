window.app = createApp({
    data() {
        return {
            all_count: 0,
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
