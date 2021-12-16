import moment from 'moment';
import { swal2Confirm } from './bootstrap';
import { search } from './components/search.js';
import { pagination } from './components/pagination.js';

window.app = createApp({
    components: {
        'components-search': search,
        'components-pagination': pagination,
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
    computed: {
        dateFormat() {
            return datetime => {
                return moment(datetime).format('Y-MM-DD HH:mm');
            }
        },
    },
    mounted() {
        this.getCount();
        this.getData(1);
    },
    methods: {
        getCount() {
            return new Promise(resolve => {
                let url = !this.search_text ? '/discount-code/count' : '/discount-code/count?keywords=' + this.search_text;
                axios.get(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = '/discount-code/list/' + page;

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
                axios.delete('/news-type/delete', {data: this.check}).then(async res => {
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
            swal2Confirm('確定刪除選取的分類？').then(confirm => {
                if (confirm) {
                    this.delete();
                }
            });
        },
    },
}).mount('#app');

let set_info = createApp({
    data() {
        return {
            mode: 'create',
            info: {
                id: null,
                records: null,
                title: '',
                full_amount: null,
                discount: null,
                is_fixed: '0',
                fixed_name: '',
                start_date: '',
                end_date: '',
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        let datetimepicker_obj = {
            locale: 'zh-tw',
            format: 'YYYY-MM-DD',
            icons: {time: 'far fa-clock'},
        };

        $('#start_date').datetimepicker(datetimepicker_obj);
        $('#end_date').datetimepicker(datetimepicker_obj);
    },
    methods: {
        dataInit() {
            $('input[data-target="#start_date"]').datetimepicker('clear');
            $('input[data-target="#end_date"]').datetimepicker('clear');
            this.info.id = null;
            this.info.records = null;
            this.info.title = '';
            this.info.full_amount = null;
            this.info.discount = null;
            this.info.is_fixed = '0';
            this.info.fixed_name = '';
            this.info.start_date = '';
            this.info.end_date = '';
        },
        auth(data) {
            if (!data.records) {
                return {auth: false, message: '請輸入優惠筆數！'};
            }

            if (isNaN(data.records)) {
                return {auth: false, message: '優惠筆數請 輸入數字！'};
            }

            if (!data.title) {
                return {auth: false, message: '請輸入標題！'};
            }

            if (!data.full_amount) {
                return {auth: false, message: '請輸入結帳金額！'};
            }

            if (isNaN(data.full_amount)) {
                return {auth: false, message: '結帳金額請 輸入數字！'};
            }

            if (!data.discount) {
                return {auth: false, message: '請輸入優惠金額！'};
            }

            if (isNaN(data.discount)) {
                return {auth: false, message: '優惠金額請 輸入數字！'};
            }

            if(data.is_fixed === '1') {
                if (!data.fixed_name) {
                    return {auth: false, message: '請輸入固定名稱！'};
                }
            }

            let start_date = $('input[data-target="#start_date"]').val();
            let end_date = $('input[data-target="#end_date"]').val();

            if (!start_date) {
                return {auth: false, message: '請選擇開始日期！'};
            }

            if (!end_date) {
                return {auth: false, message: '請選擇結束日期！'};
            }

            if (start_date > end_date) {
                return {auth: false, message: '日期格式或日期範圍錯誤！'};
            }

            data.start_date = start_date + ' 00:00:00';
            data.end_date = end_date + ' 23:59:59';

            return {auth: true, message: 'success'};
        },
        confirm() {
            let auth = this.auth(this.info);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let text = this.mode === 'create' ? '新增' : '編輯';

            swal2Confirm(`確定${text}此優惠代碼？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/discount-code/insert' : '/discount-code/update';

            loading.show = true;
            axios.post(url, this.info).then(async res => {
                if (res.data.status) {
                    $('#set-info').modal('hide');
                }

                await app.searchService();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            }).catch(error => {

            });
        },
    },
}).mount('#set-info');
