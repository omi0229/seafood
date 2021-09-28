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

        await this.getCount();
        await this.getData(1);
        loading.show = false;

        $('.directory-select2').on('select2:select', function (e) {
            loading.show = true;
            app.value.directory = e.params.data.id;
            app.getData(1);
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
        create() {

        },
        modify(id) {

        },
        specification(id) {
            set_specification.dataInit();
            set_specification.info.product_id = id;
            set_specification.getSpecification(id);
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
        }

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
            if (this.check_list.length <= 0) {
                Toast.fire({icon: 'error', title: '請選擇產品'});
                return false;
            }

            swal2Confirm(`確定修改上架產品？`).then(confirm => {
                if (confirm) {
                    console.log(this.check_list);
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/product/insert' : '/product/update';
            loading.show = true;
            let formData = new FormData;
            formData.append("id", this.info.id);
            formData.append("product_types_id", this.info.product_types_id);
            formData.append("title", this.info.title);
            formData.append("content", CKEDITOR.instances["content"].getData());
            formData.append("keywords", this.info.keywords);
            formData.append("description", this.info.description);
            formData.append("web_img_delete", this.info.web_img_delete);
            formData.append("web_img_name", this.info.web_img_name);
            formData.append("web_img", this.info.web_img);
            formData.append("mobile_img_delete", this.info.mobile_img_delete);
            formData.append("mobile_img_name", this.info.mobile_img_name);
            formData.append("mobile_img", this.info.mobile_img);
            formData.append("sales_status", this.info.sales_status);
            formData.append("show_status", this.info.show_status);

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            };

            axiosPostMethod(url, formData, config).then(async res => {
                if (res.data.status) {
                    $('#set-info').modal('hide');
                }

                await app.searchService();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            });
        },
    },
}).mount('#set-info');

let set_specification = createApp({
    data() {
        return {
            info: {
                id: null,
                product_id: null,
                name: '',
                original_price: null,
                selling_price: null,
                inventory: null,
            },
            modify_key: null,
            modify_info: {
                id: null,
                product_id: null,
                name: '',
                original_price: null,
                selling_price: null,
                inventory: null,
            },
            list: [],
            new_specification: false,
            checkAll: false,
            check: [],
        }

    },
    delimiters: ["${", "}"],
    watch: {
        'checkAll'(newData, oldData) {
            this.check = newData ? _.map(this.list, 'id') : [];
        },
    },
    methods: {
        getSpecification(id) {
            axiosGetMethod('product-specification/list/' + id).then(res => {
                if (res.data.status) {
                    this.list = res.data.data;
                }
            });
        },
        dataInit() {
            this.info.id = null;
            this.info.name = '';
            this.info.original_price = null;
            this.info.selling_price = null;
            this.info.inventory = null;
        },
        auth(data) {
            if (!data.name) {
                return {auth: false, message: '請輸入名稱！'};
            }

            if (!data.original_price) {
                return {auth: false, message: '原價不得為空！'};
            }

            if (isNaN(data.original_price)) {
                return {auth: false, message: '原價欄位請輸入數字！'};
            }

            if (!data.selling_price) {
                return {auth: false, message: '售價不得為空！'};
            }

            if (isNaN(data.selling_price)) {
                return {auth: false, message: '售價欄位請輸入數字！'};
            }

            if (data.inventory === null || isNaN(data.inventory)) {
                return {auth: false, message: '庫存欄位請輸入數字！'};
            }

            return {auth: true, message: 'success'};
        },
        confirm(mode) {
            if (mode === 'create' || mode === 'modify') {
                let auth = this.auth(this.info);
                if (!auth.auth) {
                    Toast.fire({icon: 'error', title: auth.message});
                    return false;
                }
            }

            let text = '';
            switch (mode) {
                case 'create':
                    text = '確定新增此規格？';
                    break;
                case 'modify':
                    text = '確定編輯此規格？';
                    break;
                case 'delete':
                    text = '確定刪除選取的規格？';
                    break;
            }

            swal2Confirm(text).then(confirm => {
                if (confirm) {
                    switch (mode) {
                        case 'create':
                            this.create();
                            break;
                        case 'modify':
                            this.save();
                            break;
                        case 'delete':
                            this.delete();
                            break;
                    }
                }
            });
        },
        create() {
            loading.show = true;
            axiosPostMethod('/product-specification/insert', this.info).then(async res => {
                if (res.data.status) {
                    await this.getSpecification(this.info.product_id);
                    this.new_specification = true;
                }

                this.dataInit();
                let icon = res.data.status ? 'success' : 'error';

                loading.show = false;
                Toast.fire({icon: icon, title: res.data.message});
            });
        },
        modify(key) {
            this.modify_key = key;
            this.modify_info.id = this.list[key].id;
            this.modify_info.product_id = this.info.product_id;
            this.modify_info.name = this.list[key].name;
            this.modify_info.original_price = this.list[key].original_price;
            this.modify_info.selling_price = this.list[key].selling_price;
            this.modify_info.inventory = this.list[key].inventory;
            this.new_specification = false;
        },
        save() {
            swal2Confirm(`確定變更規格資料？`).then(confirm => {
                if (confirm) {
                    loading.show = true;
                    axiosPostMethod('/product-specification/update', this.modify_info).then(async res => {
                        if (res.data.status) {
                            await this.getSpecification(this.info.product_id);
                            this.modify_key = null;
                        }

                        let icon = res.data.status ? 'success' : 'error';

                        loading.show = false;
                        Toast.fire({icon: icon, title: res.data.message});
                    });
                }
            });
        },
        cancel() {
            this.modify_key = null;
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axiosDeleteMethod('/product-specification/delete', {data: this.check}).then(async res => {
                    if (res.data.status) {
                        await this.getSpecification(this.info.product_id);
                        loading.show = false;
                        Toast.fire({icon: 'success', title: '刪除成功'});
                    }
                });
            }
        },
    },
}).mount('#set-specification');
