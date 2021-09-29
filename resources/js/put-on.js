import { ref, reactive, watch } from 'vue'
import { filter } from 'lodash'
import moment from 'moment';
import { swal2Confirm, checkAllFunction } from './bootstrap';
import { search } from './components/search.js';
import { pagination } from './components/pagination.js';
import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";



window.app = createApp({
    components: {
        'components-search': search,
        'components-pagination': pagination,
    },
    setup() {

        const { list, check, checkAll } = checkAllFunction();

        return {
            list,
            check,
            checkAll,
        }
    },
    data() {
        return {
            all_count: 0,
            page_count: 10,
            search_text: '',
            value: {
                directory: '',
            },
            select: {
                directories: [],
            },
        }
    },
    delimiters: ["${", "}"],
    async mounted() {
        await axiosGetMethod('/directory/list/all').then(res => {
            this.select.directories = res.data.data;
            $('.directory-select2').select2();
        });

        loading.show = false;

        $('.directory-select2').on('select2:select', async function (e) {
            loading.show = true;
            app.check = [];
            app.checkAll = false;
            set_info.check_list = [];

            app.value.directory = e.params.data.id;

            // 建構已上架清單
            let url = 'put-on/list/all?directories_id=' + app.value.directory;
            axiosGetMethod(url).then(res => {
                set_info.check = _.map(res.data.data, 'product.id');
                set_info.check_list = _.map(res.data.data, 'product');

            });

            await app.getCount();
            await app.getData(1);
        });

    },
    methods: {
        getCount() {
            return new Promise(resolve => {
                let url = '/put-on/count?directories_id=' + this.value.directory;
                url += !this.search_text ? '' : '&keywords=' + this.search_text;
                axiosGetMethod(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = 'put-on/list/' + page + '?directories_id=' + this.value.directory;
                url += !this.search_text ? '' : '&keywords=' + this.search_text;
                axiosGetMethod(url).then(res => {
                    app.check = [];
                    app.checkAll = false;
                    app.list = res.data.data;
                    loading.show = false;
                });
            });
        },
        put() {
            set_put.dataInit();
            set_put.check = this.check;
            set_put.list = [];
            _.forEach(set_put.check, v => {
                set_put.list.push(_.find(app.list, ['id', v]));
            })
        },
    },
}).mount('#app');

let set_info = createApp({
    setup() {
        const check_list = ref([]);

        const list = ref([]);
        const check = ref([]);
        const checkAll = ref(false);
        watch(checkAll, (newData, oldData) => {
            if (newData) {
                _.forEach(list.value, (v) => {
                    if (!check.value.includes(v.id)) {
                        check.value.push(v.id);
                    }
                });
            } else {
                _.forEach(list.value, (v) => {
                    _.remove(check.value, function(id) { return id == v.id; });
                });
            }

            setCheckList(check.value);
        });

        const value = reactive({
            product_types_id: '',
        });

        const select = reactive({
            product_types_id: [],
        });

        watch(check, (newData, oldData) => {
            setCheckList(newData);
        });

        const setCheckList = (check) => {
            if (value.product_types_id && list.value.length > 0) {
                _.forEach(list.value, v => {
                    _.remove(check_list.value, function (vv) {
                        return vv.id == v.id;
                    });
                });

                _.forEach(check, v => {
                    if (!_.find(check_list.value, ['id', v])) {
                        check_list.value.push(_.find(list.value, ['id', v]));
                    }
                });
            } else {

            }
        };

        return {
            list,
            check,
            checkAll,
            value,
            select,
            check_list,
            setCheckList,
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        this.getProductTypes().then(res => {
            this.select.product_types_id = res.data.data;
            $('.product-types-select2').select2();
        });

        $('.product-types-select2').on('select2:select', function (e) {
            loading.show = true;
            set_info.value.product_types_id = e.params.data.id;
            let url = '/product/list/all?show_status=1&product_types_id=' + set_info.value.product_types_id;
            axiosGetMethod(url).then(res => {
                set_info.list = res.data.data;
                loading.show = false;
            });
        });
    },
    methods: {
        getProductTypes() {
            return new Promise(resolve => {
                axiosGetMethod('product-type/list/all').then(res => {
                    resolve(res);
                });
            });
        },
        confirm() {
            swal2Confirm(`確定修改上架產品？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = 'put-on/insert';
            loading.show = true;

            let form_data = {
                directories_id: app.value.directory,
                check_list: this.check_list,
            };

            axiosPostMethod(url, form_data).then(async res => {
                if (res.data.status) {
                    $('#set-info').modal('hide');
                }

                await app.getCount();
                await app.getData(1);

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            });
        },
    },
}).mount('#set-info');

let set_put = createApp({
    data() {
        return {
            check: [],
            list: [],
            value: {
                status: '0',
                start_date: '',
                end_date: '',
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        let datetimepicker_obj = {
            locale: 'zh-tw',
            format: 'YYYY-MM-DD HH:mm',
            icons: {time: 'far fa-clock'},
        };

        $('#start_date').datetimepicker(datetimepicker_obj);
        $('#end_date').datetimepicker(datetimepicker_obj);
    },
    methods: {
        dataInit() {
            $('input[data-target="#start_date"]').datetimepicker('clear');
            $('input[data-target="#end_date"]').datetimepicker('clear');
            this.value.status = '0';
        },
        auth() {
            if (this.value.status == '2') {
                let start_date = $('input[data-target="#start_date"]').val();
                let end_date = $('input[data-target="#end_date"]').val();

                if (!start_date && !end_date) {
                    return {auth: false, message: '請選擇開始或結束日期！'};
                }

                if (start_date && end_date && start_date >= end_date) {
                    return {auth: false, message: '日期格式或日期範圍錯誤！'};
                }

                this.value.start_date = start_date;
                this.value.end_date = end_date;
            }

            return {auth: true, message: 'success'};
        },
        confirm() {
            let auth = this.auth();
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            swal2Confirm(`確定修改上架產品？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = '/put-on/update';
            loading.show = true;

            let form_data = {
                list: this.list,
                status: this.value.status,
                start_date: this.value.start_date,
                end_date: this.value.end_date,
            };

            axiosPostMethod(url, form_data).then(async res => {
                if (res.data.status) {
                    $('#set-put').modal('hide');
                }

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});

                await app.getData(app.$refs.pagination.page);
            });

        },
    },
}).mount('#set-put');
