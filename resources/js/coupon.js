import moment from 'moment';
import {swal2Confirm} from './bootstrap';
import {search} from './components/search.js';
import {pagination} from './components/pagination.js';

const container = {
    props: ['datas', 'type'],
    data() {
        return {
            search_word: ''
        }
    },
    template: `
        <div class="transfer-container">
        <div>{{ type === 0 ? '請選擇產品' : '可抵用產品'}}</div>
        <div class="top">
            <input :id="'transfer-all' + type" type="checkbox" name="all" @click="all" :checked="filter_chosen === filter && filter"/>
            <label :for="'transfer-all' + type"><span v-show="filter_chosen">{{ filter_chosen }}/</span>{{ filter_search_word }}項</label>
        </div>
        <input type="text" placeholder="搜尋" @keyup="change_search_word" class="search form-control form-control-sm"/>
        <ul class="transfer-contents">
            <li class="transfer-content" :class="content.chosen ? 'bg-primary' : ''" v-for="(content, idx) in datas" v-show="content.type === type && has_search_word(content.content)">
                <input :id="'transfer-content' + content.id" class="d-none" type="checkbox" @click="change(idx)" :checked="content.chosen"/>
                <label :for="'transfer-content' + content.id">{{ content.content }}</label>
            </li>
        </ul>
        </div>`,
    methods: {
        change(idx) {
            this.datas[idx].chosen = !this.datas[idx].chosen;
        },
        all() {
            this.change_chosen(!(this.filter_chosen === this.filter));
        },
        change_chosen(bool) {
            this.datas.map(x => {
                if (x.type === this.type) {
                    x.chosen = bool;
                }
            });
        },
        change_search_word(e) {
            this.search_word = e.target.value;
        },
        has_search_word(content) {
            if (this.search_word) {
                return content.includes(this.search_word);
            }
            return true;
        }
    },
    computed: {
        filter() {
            return this.datas.filter(x => x.type === this.type).length;
        },
        filter_chosen() {
            return this.datas.filter(x => x.type === this.type && x.chosen).length;
        },
        filter_search_word() {
            return this.datas.filter(x => x.type === this.type && this.has_search_word(x.content)).length;
        }
    }
};

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
            keywords: '',
        }
    },
    delimiters: ["${", "}"],
    watch: {
        'checkAll'(newData, oldData) {
            this.check = [];
            if (newData) {
                this.list.forEach(o => {
                    if (o.coupon_records_count <= 0) {
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
    async mounted() {
        await this.getCount();
        await this.getData(1);
    },
    methods: {
        setKeywords(page) {
            this.search_text = this.keywords;
            this.getData(page);
        },
        getCount() {
            return new Promise(resolve => {
                let url = !this.search_text ? '/coupon/count' : '/coupon/count?keywords=' + this.search_text;
                axiosGetMethod(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = '/coupon/list/' + page;

                if (this.search_text) {
                    url += '?keywords=' + this.search_text;
                }

                axiosGetMethod(url).then(res => {
                    this.list = res.data.data;
                    if (loading && loading.show) {
                        loading.show = false;
                    }

                    this.$refs.pagination ? this.$refs.pagination.setPage(page) : null;
                    resolve();
                });
            });
        },
        create() {
            set_info.dataInit();
            set_info.mode = 'create';
        },
        async modify(id) {
            await set_info.dataInit();
            set_info.mode = 'modify';
            set_info.info.id = id;
            let info = _.find(this.list, {'id': id});
            set_info.coupon = info.coupon;
            set_info.info.records = 0;
            set_info.info.title = info.title;
            set_info.info.full_amount = info.full_amount;
            set_info.info.discount = info.discount;
            set_info.info.start_date = info.start_date;
            set_info.info.end_date = info.end_date;

            set_info.product_specifications_list.forEach(v => {
                if (info.product_specifications_list.includes(v.id)) {
                    v.type = 1;
                }
            })

            set_info.info.product_specifications_list = info.product_specifications_list;
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/coupon/delete', {data: this.check}).then(async res => {
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
            swal2Confirm('確定刪除選取的優惠劵？').then(confirm => {
                if (confirm) {
                    this.delete();
                }
            });
        },
        shotItems(id) {
            set_show_items.value.used = '';

            let items = _.find(this.list, {'id': id});
            set_show_items.id = id;
            set_show_items.coupon_info = items;
            set_show_items.coupon_records = set_show_items.original = items.coupon_records;
        },
    },
}).mount('#app');

let set_info = createApp({
    components: {
        'container': container,
    },
    data() {
        return {
            mode: 'create',
            coupon: '',
            info: {
                id: null,
                records: null,
                title: '',
                full_amount: null,
                discount: null,
                start_date: '',
                end_date: '',
                product_specifications_list: [],
            },
            product_specifications_list: [],
            datetimepicker_obj: {
                locale: 'zh-tw',
                format: 'YYYY-MM-DD',
                icons: {time: 'far fa-clock'},
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
        change_type(type) {
            this.$data.product_specifications_list.forEach(content => {
                if (content.chosen && content.type === type) {
                    content.chosen = false;
                    content.type = Number(!type);
                }
            });
        },
        async dataInit() {
            loading.show = true;
            this.product_specifications_list = [];
            await axiosGetMethod('product-specification/all').then(res => {
                this.product_specifications_list = _.map(res.data.data, v => {
                    return {
                        content: v.product.title + ' - ' + v.name,
                        type: 0,
                        chosen: false,
                        id: v.id,
                    };
                })

                if (loading && loading.show) {
                    loading.show = false;
                }
            });

            $('input[data-target="#start_date"]').datetimepicker('clear');
            $('input[data-target="#end_date"]').datetimepicker('clear');

            this.info.id = null;
            this.info.records = null;
            this.info.title = '';
            this.info.full_amount = null;
            this.info.discount = null;
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

            if (data.records <= 0) {
                return {auth: false, message: '優惠筆數請 大於0！'};
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
        updateAuth(data) { // 編輯時用這個驗證
            if (data.records) {
                if (isNaN(data.records)) {
                    return {auth: false, message: '優惠筆數請 輸入數字！'};
                }

                if (data.records < 0) {
                    return {auth: false, message: '優惠筆數不得為負數！'};
                }
            }

            return {auth: true, message: 'success'};
        },
        confirm() {
            let auth = this.mode === 'create' ? this.auth(this.info) : this.updateAuth(this.info);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let text = this.mode === 'create' ? '新增' : '編輯';

            swal2Confirm(`確定${text}此優惠劵？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/coupon/insert' : '/coupon/update';

            let info;
            if (this.mode === 'create') {
                this.info.product_specifications_list = _.filter(this.product_specifications_list, v => { return v.type === 1 });
                info = this.info;
            } else {
                info = {
                    id: this.info.id,
                    records: this.info.records,
                    product_specifications_list: _.filter(this.product_specifications_list, v => { return v.type === 1 }),
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
            coupon_info: null,
            coupon_records: [],
            original: [],
            check: [],
            checkAll: false,
            value: {
                used: '',
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
                this.coupon_records.forEach(o => {
                    if(!o.used_at) {
                        this.check.push(o.id);
                    }
                });
            }
        },
    },
    methods: {
        recordFilter() {
            this.checkAll = false;
            switch (this.value.used) {
                case '0':
                    this.coupon_records = _.filter(this.original, o => { return !o.used_at })
                    break;
                case '1':
                    this.coupon_records = _.filter(this.original, o => { return o.used_at })
                    break;
                default:
                    this.coupon_records = this.original;
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
