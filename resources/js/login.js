import './bootstrap';

window.app = createApp({
    data() {
        return {
            account: '',
            password: '',
            status: {
                account: true,
                password: true,
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        window.loading.show = false;
    },
    methods: {
        reset() {
            this.account = '';
            this.password = '';
        },
        login() {
            this.status.account = this.status.password = true;
            if (!(this.account && this.password)) {
                if (!this.account) {
                    this.status.account = false;
                }

                if (!this.password) {
                    this.status.password = false;
                }
                return false;
            }

            this.status.account = this.status.password = true;

            let obj = {
                account: this.account,
                password: this.password,
            };

            window.loading.show = true;

            axios.post('login', obj).then(res => {
                if (res.data.status) {
                    location.href = '/';
                } else {
                    Toast.fire({icon: 'warning', title: '帳號或密碼輸入錯誤'});
                }
            }).catch(error => {

            });
        }
    },
}).mount('#login');
