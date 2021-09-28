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
            set_info.check_list = [];
            app.value.directory = e.params.data.id;
            await app.getCount();
            await app.getData(1).then(res => {
                app.list = res.data.data;
                set_info.check = _.map(app.list, 'product.id');
                set_info.check_list = _.map(app.list, 'product');
                loading.show = false;
            });
        });

    },
    methods: {
        getCount() {
            return new Promise(resolve => {
                let url = !this.search_text ? '/product/count' : '/product/count?keywords=' + this.search_text;
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
                axiosGetMethod(url).then(res => {
                    resolve(res);
                });
            });
        },
        modify() {
            set_info.check = set_info.check_list = [];
            set_info.check = _.map(app.list, 'product.id');
            set_info.check_list = _.map(app.list, 'product');
        },
        put() {
            set_put.check = this.check;
            set_put.list = [];
            _.forEach(set_put.check, v => {
                set_put.list.push(_.find(app.list, ['id', v]));
            })

            console.log(set_put.list);
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axiosDeleteMethod('/product/delete', {data: this.check}).then(async res => {
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

                await app.getData(1).then(res => {
                    app.list = res.data.data;
                });

                loading.show = false;

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
            },
        }
    },
    delimiters: ["${", "}"],
    methods: {

    },
}).mount('#set-put');
