import { passwordRule, emailRule, swal2Confirm, getUser, getRoles } from './bootstrap';
import { search } from './components/search.js';
import { pagination } from './components/pagination.js';

window.app = createApp({
    components: {
        'components-search': search,
        'components-pagination': pagination,
    },
    setup() {

    },
    data() {
        return {
            all_count: 0,
            page_count: 10,
            checkAll: false,
            check: [],
            list: [],
            search_text: '',
        }
    },
    delimiters: ["${", "}"],
    watch: {
        'checkAll'(newData, oldData) {
            this.check = newData ? _.map(this.list, 'id') : [];
        },
    },
    mounted() {
        this.getCount();
        this.getData(1);
    },
    methods: {
        getCount() {
            return new Promise(resolve => {
                let url = !this.search_text ? '/user/count' : '/user/count?keywords=' + this.search_text;
                axios.get(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
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
        modify(id) {
            set_user.dataInit();
            set_user.mode = 'modify';
            set_user.user_info.id = id;
            let info = _.find(this.list, {'id': id});
            set_user.user_info.account = info.account;
            set_user.user_info.name = info.name;
            set_user.user_info.email = info.email;
            set_user.user_info.active = info.active.toString();
            set_user.user_info.role.id = info.role_id;
            set_user.user_info.role.name = info.role_name;
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/user/delete', {data: this.check}).then(async res => {
                    if (res.data.status) {
                        Toast.fire({icon: 'success', title: '刪除成功'});
                        this.searchService('delete');
                    }
                });
            }
        },
        searchService(type = null) {
            return new Promise(async resolve => {
                await this.getCount();
                await this.getData(this.$refs.pagination.page);
                if (this.$refs.pagination.page > 1 && this.list.length === 0) {
                    if (type === 'delete' || this.search_text) {
                        loading.show = true;
                        await this.getData(1);
                        this.$refs.pagination.setPage(1);
                    }
                }

                resolve();
            });
        },
        confirm() {
            swal2Confirm('確定刪除選取的管理員？').then(confirm => {
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
                name: '',
                password: '',
                auth_password: '',
                email: '',
                role: {
                    id: '',
                    name: '',
                },
                active: '1',
            },
            select: {
                roles: [],
            }
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        getRoles().then(res => {
            this.select.roles = res.data.data;
        });
    },
    methods: {
        dataInit() {
            this.user_info.id = null;
            this.user_info.account = '';
            this.user_info.name = '';
            this.user_info.password = '';
            this.user_info.auth_password = '';
            this.user_info.email = '';
            this.user_info.role.id = '';
            this.user_info.role.name = '';
            this.user_info.active = '1';
        },
        auth(data) {
            if (!data.account) {
                return {auth: false, message: '帳號不得為空！'};
            }

            let obj = {
                account: data.account,
            };

            console.log(getUser(obj));
            return;

            if (getUser(obj)) {
                return {auth: false, message: '帳號重複！'};
            }

            if (!data.name) {
                return {auth: false, message: '姓名不得為空！'};
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

            if (!data.role) {
                return {auth: false, message: '請選擇權限！'};
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

            swal2Confirm(`確定${text}此管理員？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/user/insert' : '/user/update';
            loading.show = true;
            axios.post(url, this.user_info).then(async res => {
                $('#set-user').modal('hide');

                await app.searchService();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            }).catch(error => {

            });
        },
    },
}).mount('#set-user');
