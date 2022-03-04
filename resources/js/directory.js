import { swal2Confirm } from './bootstrap';
import { search } from './components/search.js';
import { pagination } from './components/pagination.js';
import { table } from './components/table.js';

window.app = createApp({
    components: {
        'components-search': search,
        'components-pagination': pagination,
        'components-table': table,
    },
    setup() {

    },
    data() {
        return {
            all_count: 0,
            page_count: 10,
            check: [],
            list: [],
            search_text: '',
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        this.getCount();
        this.getData(1);
    },
    methods: {
        getCount() {
            return new Promise(resolve => {
                let url = !this.search_text ? '/directory/count' : '/directory/count?keywords=' + this.search_text;
                axiosGetMethod(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = '/directory/list/' + page;

                if (this.search_text) {
                    url += '?keywords=' + this.search_text;
                }

                axiosGetMethod(url).then(res => {
                    this.list = res.data.data;
                    if (loading && loading.show) {
                        loading.show = false;
                    }
                    resolve();
                });
            });
        },
        create() {
            set_info.dataInit();
            set_info.mode = 'create';
        },
        modify(id) {
            set_info.dataInit();
            set_info.mode = 'modify';
            set_info.user_info.id = id;
            let info = _.find(this.list, {'id': id});
            set_info.user_info.name = info.name;
            set_info.user_info.check = _.map(info.permissions, 'name');
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/directory/delete', {data: this.check}).then(async res => {
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
            axiosPostMethod('/directory/check-delete', {data: this.check}).then(async res => {
                if (res.data.count > 0) {
                    Toast.fire({icon: 'error', title: '以下目錄 ' + res.data.message + ' 於「上架管理」功能內尚有產品，不得刪除'});
                    return false;
                } else {
                    swal2Confirm('確定刪除選取的目錄？').then(confirm => {
                        if (confirm) {
                            this.delete();
                        }
                    });
                }
            });
        },
    },
}).mount('#app');

let set_info = createApp({
    data() {
        return {
            mode: 'create',
            user_info: {
                name: '',
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
    },
    methods: {
        dataInit() {
            this.checkAll = false;
            this.user_info.name = '';
        },
        auth(data) {
            if (!data.name) {
                return {auth: false, message: '名稱不得為空！'};
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

            swal2Confirm(`確定${text}此分類？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/directory/insert' : '/directory/update';
            loading.show = true;

            axiosPostMethod(url, this.user_info).then(async res => {
                if (res.data.status) {
                    $('#set-info').modal('hide');
                }

                await app.searchService();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            })
        },
    },
}).mount('#set-info');
