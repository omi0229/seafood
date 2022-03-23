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
            check_print: [],
            list: [],
            search_text: '',
            search: {
                order_status: '',
                payment_status: '',
                start_date: '',
                end_date: '',
            },
            order_products: [],
            ECPay: [],
            url: {
                print: '',
            },
            value: {
                specification: '0001',
            },
            radio: {
                specification: [
                    {
                        value: '0001',
                        name: '60cm',
                    },
                    {
                        value: '0002',
                        name: '90cm',
                    },
                    {
                        value: '0003',
                        name: '120cm',
                    },
                ],
            },
        }
    },
    delimiters: ["${", "}"],
    watch: {
        'checkAll'(newData, oldData) {
            this.check_print = [];
            if(newData) {
                this.list.forEach(v => {
                    if (v.AllPayLogisticsID) {
                        this.check_print.push(v.AllPayLogisticsID);
                    }
                })
            }
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
        paymentStatusColor() {
            return status => {
                switch (Number(status)) {
                    case 0:
                        return 'text-danger';
                    case 1:
                        return 'text-primary';
                    default:
                        return 'text-default';
                }
            }
        },
        deliveryMethodFormat() {
            return status => {
                switch (status) {
                    case 1:
                        return '宅配';
                    default:
                        return '自取';
                }
            }
        },
        deliveryMethodColor() {
            return status => {
                switch (Number(status)) {
                    case 1:
                        return 'text-primary';
                    default:
                        return 'text-default';
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
        orderTotal() {
              return (freight, list, discount_record = null, coupon_record = null) => {
                  let price = 0;
                  list.forEach(v => { price += v.price * v.count });

                  // 有使用優惠代碼
                  if (discount_record && discount_record.discount_codes) {
                      if (price >= discount_record.discount_codes.full_amount) {
                          price -= discount_record.discount_codes.discount;
                      }
                  }

                  // 有使用優惠劵
                  if (coupon_record && coupon_record.coupon) {
                      if (price >= coupon_record.coupon.full_amount) {
                          price -= coupon_record.coupon.discount;
                      }
                  }

                  price += freight;

                  return price.toLocaleString();
              }
        },
    },
    async mounted() {
        $('#reservation').daterangepicker({
            locale: {
                format: 'Y-MM-DD',
                applyLabel: '確定',
                cancelLabel: '清空',
            },
            autoUpdateInput: false,
        });
        $('#reservation').on('apply.daterangepicker', async (ev, picker) => {
            loading.show = true;
            this.search.start_date = picker.startDate.format('YYYY-MM-DD');
            this.search.end_date = picker.endDate.format('YYYY-MM-DD');
            await this.getCount();
            this.getData(1).then(() => {
                loading.show = false;
            });
        });
        $('#reservation').on('cancel.daterangepicker', async (ev, picker) => {
            loading.show = true;
            this.search.start_date = '';
            this.search.end_date = '';
            await this.getCount();
            this.getData(1).then(() => {
                loading.show = false;
            });
        });

        if (sessionStorage.getItem('keywords')) {
            this.search_text = sessionStorage.getItem('keywords');
            sessionStorage.removeItem('keywords')
        }

        await axiosGetMethod('/orders/get/logistics-print-url').then(res => {
            this.url.print = res.data.data;
        });

        await this.getCount();
        await this.getData(1);
    },
    methods: {
        getUri() {
            let search_uri = '';

            if (this.search_text) {
                search_uri += '?keywords=' + this.search_text;
            }

            if (this.search.order_status !== '') {
                search_uri += !search_uri ? '?order_status=' + this.search.order_status : '&order_status=' + this.search.order_status;
            }

            if (this.search.payment_status === 0) {
                search_uri += !search_uri ? '?payment_status=' + this.search.payment_status : '&payment_status=' + this.search.payment_status;
            }

            if (this.search.start_date && this.search.end_date) {
                search_uri += !search_uri ? '?start_date=' + this.search.start_date : '&start_date=' + this.search.start_date;
                search_uri += '&end_date=' + this.search.end_date;
            }

            return search_uri;
        },
        getCount() {
            return new Promise(resolve => {
                let url = '/orders/count';
                axiosGetMethod(url + this.getUri()).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = '/orders/list/' + page;
                axiosGetMethod(url + this.getUri()).then(res => {
                    this.list = res.data.data;
                    if (loading && loading.show) {
                        loading.show = false;
                    }

                    this.check = [];
                    this.$refs.pagination.setPage(page);
                    resolve();
                });
            });
        },
        // create() {
        //     detailed_content.dataInit();
        //     detailed_content.mode = 'create';
        // },
        async changeStatus(status, type = 'order') {
            loading.show = true;
            if (type === 'payment') {
                this.search.order_status = '';
                this.search.payment_status = status;
            } else {
                this.search.order_status = status;
                this.search.payment_status = '';
            }

            await this.getCount();
            this.getData(1).then(() => {
                loading.show = false;
            });
        },
        detail(id) {

            detailed_content.dataInit();

            detailed_content.mode = 'modify';
            detailed_content.info.id = id;
            let info = _.find(this.list, {'id': id});

            detailed_content.info.merchant_trade_no = info.merchant_trade_no;
            detailed_content.info.freight = info.freight
            detailed_content.info.freight_name = info.freight_name
            detailed_content.info.delivery_method = info.delivery_method
            detailed_content.info.payment_method = info.payment_method;
            detailed_content.info.invoice_method = info.invoice_method;
            detailed_content.info.invoice_tax_id_number = info.invoice_tax_id_number;
            detailed_content.info.invoice_name = info.invoice_name;
            detailed_content.info.order_status = info.order_status;

            detailed_content.info.shipment_at = info.shipment_at;
            if (info.shipment_at) {
                $('input[data-target="#shipment_date"]').val(info.shipment_at.substr(0, 10));
            }

            detailed_content.info.MerchantTradeNo = info.MerchantTradeNo;
            detailed_content.info.AllPayLogisticsID = info.AllPayLogisticsID;
            detailed_content.info.BookingNote = info.BookingNote;
            detailed_content.info.RtnCode = info.RtnCode;
            detailed_content.info.RtnMsg = info.RtnMsg;
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
            detailed_content.info.discount_record = info.discount_record;
            detailed_content.info.coupon_record = info.coupon_record;
        },
        // delete() {
        //     if(this.check.length > 0) {
        //         loading.show = true;
        //         axiosDeleteMethod('/cooking/delete', {data: this.check}).then(async res => {
        //             if (res.data.status) {
        //                 Toast.fire({icon: 'success', title: '刪除成功'});
        //                 this.searchService('delete');
        //             }
        //         });
        //     }
        // },
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
            swal2Confirm('確定送出？').then(confirm => {
                if (confirm) {
                    this.logistics();
                }
            });
        },
        exportData(type) {
            switch (type) {
                case 'orders':
                    window.open('/orders/export/orders' + this.getUri());
                    break;
                case 'all':
                    window.open('/orders/export/all');
                    break;
                case 'products':
                    window.open('/orders/export/products');
                    break;
            }
        },
        specification() {
            if (this.check.length !== 1) {
                Toast.fire({icon: 'error', title: '請選擇一項訂單！'});
                return false;
            }

            this.value.specification = '0001';

            let info = _.find(this.list, ['id', this.check[0]]);
            this.order_products = info.order_products;

            $('#specification').modal('show');
        },
        logistics() {
            if (this.check.length !== 1) {
                Toast.fire({icon: 'error', title: '請選擇一項訂單！'});
                return false;
            }

            loading.show = true;
            this.ECPay = [];
            if (this.check.length === 1) {

                let info = _.find(this.list, ['id', this.check[0]]);
                if (info) {
                    let obj = {
                        order_id: this.check[0],
                        order_total: this.orderTotal(info.freight, info.order_products, info.discount_record, info.coupon_record),
                        Specification: this.value.specification,
                    };

                    axiosPostMethod('/orders/form-data/logistics', obj).then(res => {
                        if (res.data.status) {
                            this.searchService().then(() => {
                                loading.show = false;
                                $('#specification').modal('hide');
                                Toast.fire({icon: 'success', title: res.data.message});
                            });
                        } else {
                            Toast.fire({icon: 'error', title: res.data.message});
                            loading.show = false;
                        }
                    });
                }
            }
        },
        print() {
            if (this.check_print.length < 1) {
                Toast.fire({icon: 'error', title: '請至少選擇一項「已取號」訂單'});
                return false
            }

            loading.show = true;
            axiosPostMethod('/orders/print/logistics', this.check_print).then(res => {
                for (const [key, value] of Object.entries(res.data.ecpay)) {
                    this.ECPay.push({
                        key: key,
                        value: value,
                    })
                }

                setTimeout(() => {
                    document.getElementById('form').submit();
                    loading.show = false;
                }, 1000)
            });
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
                MerchantTradeNo: '',
                AllPayLogisticsID: '',
                BookingNote: '',
                RtnCode: '',
                RtnMsg: '',
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
                discount_record: null,
                coupon_record: null,
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
        deliveryMethodFormat() {
            return delivery => {
                switch (delivery) {
                    case 0:
                        return '自取';
                    case 1:
                        return '宅配到府';
                    default:
                        return '';
                }
            }
        },
        paymentMethodFormat() {
            return payment => {
                switch (payment) {
                    case 1:
                        return '信用卡';
                    case 2:
                        return 'ATM';
                    case 3:
                        return 'Line Pay';
                    default:
                        return '';
                }
            }
        },
        orderTotal() {
            return (freight, list, discount_record = null, coupon_record = null) => {
                let price = 0;
                list.forEach(v => { price += v.price * v.count });

                // 有使用優惠代碼
                if (discount_record && discount_record.discount_codes) {
                    if (price >= discount_record.discount_codes.full_amount) {
                        price -= discount_record.discount_codes.discount;
                    }
                }

                // 有使用優惠劵
                if (coupon_record && coupon_record.coupon) {
                    if (price >= coupon_record.coupon.full_amount) {
                        price -= coupon_record.coupon.discount;
                    }
                }

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

            if (data.delivery_method !== 0) {
                if (!(data.receiver.zipcode && data.receiver.country && data.receiver.city && data.receiver.address)) {
                    return {auth: false, message: '收件人地址格式錯誤！'};
                }
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
