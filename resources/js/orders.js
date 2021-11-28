import moment from 'moment';
import { swal2Confirm } from './bootstrap';
import { search } from './components/search.js';
import { pagination } from './components/pagination.js';
import twzipcode from 'twzipcode-data'

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
        paymentStatusFormat() {
            return status => {
                switch (status) {
                    case 0:
                      return '尚未付款';
                    case 1:
                      return '付款成功';
                    case -1:
                      return '付款金額錯誤';
                    case -2:
                      return '付款失敗';
                    default:
                        return '';
                }
            }
        },
        orderStatusFormat() {
            return status => {
                switch (Number(status)) {
                    case -2:
                        return '退貨';
                    case -1:
                        return '取消';
                    case 0:
                        return '新單';
                    case 1:
                        return '收款';
                    case 2:
                        return '出貨';
                    case 3:
                        return '完成';
                    default:
                        return '';
                }
            }
        },
        orderStatusColor() {
            return status => {
                switch (Number(status)) {
                    case -2:
                        return 'text-danger text-bold';
                    case -1:
                        return 'text-danger';
                    case 0:
                        return '';
                    case 1:
                        return 'text-primary';
                    case 2:
                        return 'text-primary text-bold';
                    case 3:
                        return 'text-success text-bold';
                    default:
                        return '';
                }
            }
        },
        order_total() {
              return (freight, list) => {
                  let price = 0;
                  list.forEach(v => { price += v.price * v.count });
                  price += freight;
                  return price.toLocaleString();
              }
        }
    },
    async mounted() {

        if (sessionStorage.getItem('keywords')) {
            this.search_text = sessionStorage.getItem('keywords');
            sessionStorage.removeItem('keywords')
        }

        await this.getCount();
        await this.getData(1);
    },
    methods: {
        getCount() {
            return new Promise(resolve => {
                let url = !this.search_text ? '/orders/count' : '/orders/count?keywords=' + this.search_text;
                axiosGetMethod(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = '/orders/list/' + page;

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
            detailed_content.dataInit();
            detailed_content.mode = 'create';
        },
        detail(id) {

            detailed_content.dataInit();

            detailed_content.mode = 'modify';
            detailed_content.info.id = id;
            let info = _.find(this.list, {'id': id});

            detailed_content.info.merchant_trade_no = info.merchant_trade_no;
            detailed_content.info.freight = info.freight
            detailed_content.info.freight_name = info.freight_name
            detailed_content.info.payment_method = info.payment_method;
            detailed_content.info.invoice_method = info.invoice_method;
            detailed_content.info.invoice_tax_id_number = info.invoice_tax_id_number;
            detailed_content.info.invoice_name = info.invoice_name;
            detailed_content.info.order_status = info.order_status;

            detailed_content.info.shipment_at = info.shipment_at;
            if (info.shipment_at) {
                $('input[data-target="#shipment_date"]').val(info.shipment_at.substr(0, 10));
            }

            detailed_content.info.bookmark = info.bookmark;
            detailed_content.info.admin_bookmark = info.admin_bookmark;
            detailed_content.info.created_at = info.created_at;

            detailed_content.info.member.name = info.member.name;
            detailed_content.info.member.email = info.member.email;
            detailed_content.info.member.cellphone = info.member.cellphone;
            detailed_content.info.member.telephone = info.member.telephone;

            detailed_content.info.receiver.name = info.name;
            detailed_content.info.receiver.cellphone = info.cellphone;
            detailed_content.info.receiver.email = info.email;
            detailed_content.info.receiver.country = info.country;
            detailed_content.selectCountry('receiver');
            detailed_content.info.receiver.city = info.city;
            detailed_content.info.receiver.zipcode = info.zipcode;
            detailed_content.info.receiver.address = info.address;

            detailed_content.info.order_products = info.order_products;
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axiosDeleteMethod('/cooking/delete', {data: this.check}).then(async res => {
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
            swal2Confirm('確定刪除選取的項目？').then(confirm => {
                if (confirm) {
                    this.delete();
                }
            });
        },
        exportData(type) {
            switch (type) {
                case 'orders':
                    window.open('/orders/export/orders');
                    break;
                case 'all':
                    window.open('/orders/export/all');
                    break;
                case 'products':
                    window.open('/orders/export/products');
                    break;
            }
        },
    },
}).mount('#app');

let detailed_content = createApp({
    data() {
        let origin_zipcode = twzipcode();
        return {
            mode: 'create',
            date: new Date(),
            info: {
                id: '',
                merchant_trade_no: '',
                freight: 0,
                freight_name: '',
                shipment_at: '',
                admin_bookmark: '',
                member: {
                    name: '',
                    email: '',
                    cellphone: '',
                    telephone: '',
                },
                receiver: {
                    name: '',
                    cellphone: '',
                    email: '',
                    zipcode: '',
                    country: '',
                    city: '',
                    address: '',
                },
                payment_method: '',
                invoice_method: '',
                invoice_tax_id_number: '',
                invoice_name: '',
                order_status: '',
                bookmark: '',
                created_at: '',
                order_products: [],
            },
            value: {
                keyword: '',
            },
            select: {
                counties: [],
                cities: [],
                main_island_counties: [],
                main_island_cities: [],
            },
            origin_zipcode,
        }
    },
    delimiters: ["${", "}"],
    computed: {
        dateFormat() {
            return datetime => {
                return moment(datetime).format('Y-MM-DD HH:mm');
            }
        },
        paymentMethodFormat() {
            return payment => {
                switch (payment) {
                    case 1:
                        return '信用卡';
                    case 2:
                        return 'ATM';
                    default:
                        return '';
                }
            }
        },
        orderTotal() {
            return (freight, list) => {
                let price = 0;
                list.forEach(v => { price += v.price * v.count });
                price += freight;
                return price.toLocaleString();
            }
        },
    },
    mounted() {
        let datetimepicker_obj = { locale: 'zh-tw', format: 'YYYY-MM-DD', icons: {time: 'far fa-clock'} };
        $('#shipment_date').datetimepicker(datetimepicker_obj);

        this.select.counties = this.origin_zipcode.counties;
        this.select.main_island_counties = _.filter(this.select.counties, v => {
            return v.name !== '澎湖縣' && v.name !== '金門縣' && v.name !== '連江縣';
        });
    },
    methods: {
        selectCountry(type = null) {
            if (type === 'receiver') {
                this.info.receiver.city = '';
                this.info.receiver.zipcode = '';
                this.select.main_island_cities = _.filter(this.origin_zipcode.zipcodes, v => {
                    return v.county === this.info.receiver.country && v.city !== '釣魚臺列嶼' && v.city !== '東沙群島' && v.city !== '南沙群島' && v.city !== '琉球鄉' && v.city !== '綠島鄉' && v.city !== '蘭嶼鄉';
                });
            } else {
                this.form.city = '';
                this.form.zipcode = '';
                this.select.cities = _.filter(this.origin_zipcode.zipcodes, v => {
                    return v.county === this.form.country
                });
            }
        },
        selectCity(type = null) {
            if (type === 'receiver') {
                this.info.receiver.zipcode = '';
                if (this.info.receiver.city) {
                    this.info.receiver.zipcode = _.find(this.select.main_island_cities, ['city', this.info.receiver.city]).zipcode;
                }
            } else {
                this.form.zipcode = '';
                if (this.form.city) {
                    this.form.zipcode = _.find(this.select.cities, ['city', this.form.city]).zipcode;
                }
            }
        },
        addKeyword() {
            if (!this.value.keyword) {
                Toast.fire({icon: 'error', title: '請輸入關鍵字'});
                return false;
            }

            if (this.info.keywords.length < 10) {
                this.info.keywords.push(this.value.keyword);
            } else {
                Toast.fire({icon: 'error', title: '最多設定10個關鍵字'});
            }
        },
        deleteKeyword(key) {
            this.info.keywords = _.remove(this.info.keywords, function (v, k) {
                return k != key;
            });
        },
        dataInit() {
            $('input[data-target="#shipment_date"]').datetimepicker('clear');
            this.info.shipment_at = '';
            this.info.admin_bookmark = '';
        },
        auth(data) {
            if (!data.receiver.name) {
                return {auth: false, message: '收件人姓名不得為空！'};
            }

            if (!data.receiver.cellphone) {
                return {auth: false, message: '收件人手機號碼不得為空！'};
            }

            if (data.receiver.cellphone.length !== 10) {
                return {'status': false, 'message': '行動電話長度須為10碼'}
            }

            if (data.receiver.cellphone.substr(0, 2) !== '09') {
                return {'status': false, 'message': '行動電話格式錯誤'}
            }

            if (!(data.receiver.zipcode && data.receiver.country && data.receiver.city && data.receiver.address)) {
                return {auth: false, message: '收件人地址格式錯誤！'};
            }

            data.shipment_at = $('input[data-target="#shipment_date"]').val();

            return {auth: true, message: 'success'};
        },
        confirm() {
            let auth = this.auth(this.info);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let text = this.mode === 'create' ? '新增' : '編輯';

            swal2Confirm(`確定${text}此資料？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/orders/insert' : '/orders/update';
            loading.show = true;

            axiosPostMethod(url, this.info).then(async res => {
                res.data.status ? $('#detail').modal('hide') : null;

                await app.searchService();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            });
        },
    },
}).mount('#detail');