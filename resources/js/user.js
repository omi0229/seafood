import { passwordRule, emailRule } from './bootstrap';

let setData = (data) => {
    console.log(12345);
}

window.app = createApp({
    data() {
        return {
            list: [],
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        loading.show = false;
    },
    methods: {
        create() {
            set_user.dataInit();
            set_user.mode = 'create';
        },
        modify(user_id) {
            set_user.dataInit();
            set_user.mode = 'modify';
            set_user.user_info.id = user_id;
            let info = _.find(this.list, {'id': user_id});
            set_user.user_info.account = info.account;
            set_user.user_info.email = info.email;
        },
    },
}).mount('#app');

let set_user = createApp({
    data() {
        return {
            mode: 'create',
            user_info: {
                id: null,
                account: '',
                password: '',
                auth_password: '',
                email: ''
            },
        }
    },
    delimiters: ["${", "}"],
    methods: {
        dataInit() {
            this.user_info.id = null;
            this.user_info.account = '';
            this.user_info.password = '';
            this.user_info.auth_password = '';
            this.user_info.email = '';
        },
        auth(data) {
            if (!data.account) {
                return {auth: false, message: '帳號不得為空！'};
            }

            if (!data.email) {
                return {auth: false, message: '電子郵件不得為空！'};
            }

            if (!emailRule(data.email)) {
                return {auth: false, message: '電子郵件格式錯誤！'};
            }

            if (this.mode == 'create') {
                if (!passwordRule(data.password)) {
                    return {auth: false, message: '密碼規則需為8碼以上數字加英文！'};
                }

                if (!data.password) {
                    return {auth: false, message: '密碼不得為空！'};
                }

                if (data.password !== data.auth_password) {
                    return {auth: false, message: '密碼與密碼確認不同！'};
                }
            } else {
                if (data.password) {
                    if (!passwordRule(data.password)) {
                        return {auth: false, message: '密碼規則需為8碼以上數字加英文！'};
                    }

                    if (data.password !== data.auth_password) {
                        return {auth: false, message: '密碼與密碼確認不同！'};
                    }
                }
            }

            return {auth: true, message: 'success'};
        },
        save() {
            let auth = this.auth(this.user_info);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let url = this.mode === 'create' ? '/user/insert' : '/user/update';

            loading.show = true;

            axios.post(url, this.user_info).then(res => {
                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
                $('#set-user').modal('hide');
                loading.show = false;
            }).catch(error => {

            });
        }
    },
}).mount('#set-user');
