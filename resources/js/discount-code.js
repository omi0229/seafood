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
            this.check = [];
            if (newData) {
                this.list.forEach(o => {
                    if (o.discount_records_count <= 0) {
                        this.check.push(o.id);
                    }
                });
            }
        },
    },
    computed: {
        dateFormat() {
            return datetime => {
                return moment(datetime).format('Y-MM-DD');
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
                axiosGetMethod(url).then(res => {
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
            set_info.info.id = id;
            let info = _.find(this.list, {'id': id});
            set_info.info.records = 0;
            set_info.info.title = info.title;
            set_info.info.full_amount = info.full_amount;
            set_info.info.discount = info.discount;
            set_info.info.is_fixed = info.is_fixed;
            set_info.info.fixed_name = info.fixed_name;
            set_info.info.start_date = info.start_date;
            set_info.info.end_date = info.end_date;
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/discount-code/delete', {data: this.check}).then(async res => {
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
        shotItems(id) {
            let items = _.find(this.list, {'id': id});
            set_show_items.id = id;
            set_show_items.discount_codes = items;
            set_show_items.discount_records = set_show_items.original = items.discount_records;
        }
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
            datetimepicker_obj: {
                locale: 'zh-tw',
                format: 'YYYY-MM-DD',
                icons: {time: 'far fa-clock'},
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
    },
    methods: {
        dataInit() {
            this.info.id = null;
            this.info.records = null;
            this.info.title = '';
            this.info.full_amount = null;
            this.info.discount = null;
            this.info.is_fixed = '0';
            this.info.fixed_name = '';
            this.info.start_date = '';
            this.info.end_date = '';

            setTimeout(() => {
                let datetimepicker_obj = {
                    locale: 'zh-tw',
                    format: 'YYYY-MM-DD',
                    icons: {time: 'far fa-clock'},
                };
                $('#start_date').datetimepicker(datetimepicker_obj);
                $('#end_date').datetimepicker(datetimepicker_obj);
            }, 1)
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
            if (this.mode === 'create') {
                let auth = this.auth(this.info);
                if (!auth.auth) {
                    Toast.fire({icon: 'error', title: auth.message});
                    return false;
                }
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

            let info;
            if (this.mode === 'create') {
                info = this.info;
            } else {
                info = {
                    id: this.info.id,
                    records: this.info.records,
                };
            }

            loading.show = true;
            axios.post(url, info).then(async res => {
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

let set_show_items = createApp({
    data() {
        return {
            id: null,
            discount_codes: null,
            discount_records: [],
            original: [],
            check: [],
            checkAll: false,
            value: {
                payment_status: '',
            }
        }
    },
    delimiters: ["${", "}"],
    computed: {
        dateFormat() {
            return datetime => {
                return moment(datetime).format('Y-MM-DD HH:mm');
            }
        },
    },
    watch: {
        'checkAll'(newData, oldData) {
            this.check = [];
            if(newData) {
                this.discount_records.forEach(o => {
                    if(o.order.payment_status !== 1) {
                        this.check.push(o.id);
                    }
                });
            }
        },
    },
    methods: {
        recordFilter() {
            this.checkAll = false;
            if(this.value.payment_status || this.value.payment_status === 0){
                this.discount_records = _.filter(this.original, o => { return o.order.payment_status === Number(this.value.payment_status); })
            } else {
                this.discount_records = this.original;
            }
        },
        confirm() {
            swal2Confirm('確定刪除此紀錄？').then(confirm => {
                if (confirm) {
                    this.delete();
                }
            });
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axiosDeleteMethod('/discount-code/record-delete', {data: this.check}).then(async res => {
                    if (res.data.status) {
                        loading.show = false;
                        await app.searchService();
                        app.shotItems(this.id);
                        Toast.fire({icon: 'success', title: '刪除成功'});
                    }
                });
            }
        },
        orders(merchant_trade_no) {
            sessionStorage.setItem('keywords', merchant_trade_no);
            location.href = '/orders';
        },
    },
}).mount('#set-show-items');
