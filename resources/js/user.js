import { passwordRule, emailRule, swal2Confirm } from './bootstrap';
import { search } from './components/search.js';

window.app = createApp({
    components: {
        'components-search': search,
    },
    data() {
        return {
            checkAll: false,
            check: [],
            list: [],
            search_text: '',
        }
    },
    delimiters: ["${", "}"],
    watch: {
        'checkAll'(newData, oldData) {
            if (newData) {
                this.check = _.map(this.list, 'id');
            } else {
                this.check = [];
            }
        },
    },
    mounted() {
        this.getUsers(1).then(() => {
            loading.show = false;
        });
    },
    methods: {
        getUsers(page) {
            return new Promise(resolve => {
                let url = '/user/list/' + page;

                if (this.search_text) {
                    url += '?keywords=' + this.search_text;
                }

                axios.get(url).then(res => {
                    this.list = res.data.data;
                    if (loading && loading.show) {
                        loading.show = false;
                    }
                    resolve();
                });
            });
        },
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
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/user/delete', {data: this.check}).then(async res => {
                    if (res.data.status) {
                        Toast.fire({icon: 'success', title: '刪除成功'});
                        await app.getUsers(1);
                        loading.show = false;
                    }
                });
            }
        },
        confirm() {
            swal2Confirm('確定刪除選取的使用者？').then(confirm => {
                if (confirm) {
                    this.delete();
                }
            });
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
        confirm() {
            let auth = this.auth(this.user_info);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let text = this.mode === 'create' ? '新增' : '編輯';

            swal2Confirm(`確定${text}此使用者？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/user/insert' : '/user/update';
            loading.show = true;
            axios.post(url, this.user_info).then(async res => {
                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
                $('#set-user').modal('hide');
                await app.getUsers(1);
                loading.show = false;
            }).catch(error => {

            });
        },
    },
}).mount('#set-user');
