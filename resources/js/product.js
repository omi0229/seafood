import moment from 'moment';
import { swal2Confirm } from './bootstrap';
import { search } from './components/search.js';
import { pagination } from './components/pagination.js';
import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";

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
    async mounted() {
        await this.getCount();
        await this.getData(1);
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
                let url = '/product/list/' + page;

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
            CKEDITOR.instances["content"].setData('');
            set_info.dataInit();
            set_info.mode = 'create';
        },
        modify(id) {
            set_info.dataInit();
            set_info.mode = 'modify';
            set_info.info.id = id;
            let info = _.find(this.list, {'id': id});
            set_info.info.product_types_id = info.product_types_id;
            set_info.info.title = info.title;
            CKEDITOR.instances["content"].setData(info.content);
            set_info.info.keywords = info.keywords ? info.keywords.split(',') : [];
            set_info.info.description = info.description;
            set_info.info.product_front_cover_image_id = info.product_front_cover_image_id;

            info.web_img_list.forEach(v => { v.delete = 0; })
            set_info.info.web_img_list = info.web_img_list;

            info.mobile_img_list.forEach(v => { v.delete = 0; })
            set_info.info.mobile_img_list = info.mobile_img_list;

            set_info.info.sales_status = info.sales_status;
            set_info.info.show_status = info.show_status;
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
                        this.searchService('delete');
                        Toast.fire({icon: 'success', title: '刪除成功'});
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
            axiosPostMethod('/product/check-delete', {data: this.check}).then(async res => {
                if (res.data.count > 0) {
                    Toast.fire({icon: 'error', title: '以下產品 ' + res.data.message + ' 已於上架管理設定，不得刪除'});
                    return false;
                } else {
                    swal2Confirm('確定刪除選取的項目？').then(confirm => {
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
            date: new Date(),
            info: {
                id: '',
                product_types_id: '',
                title: '',
                content: '',
                keywords: [],
                description: '',
                product_front_cover_image_id: '',
                web_img_list: [],
                web_new_img_list: [],
                mobile_img_list: [],
                mobile_new_img_list: [],
                sales_status: '0',
                show_status: '0',
            },
            value: {
                keyword: '',
            },
            select: {
                product_types: [],
            },
        }
    },
    delimiters: ["${", "}"],
    computed: {
        fileRead() {
            return file => {
                return URL.createObjectURL(file);
            }
        },
        imageCount() {
            let list = _.filter(this.info.web_img_list, v => {
                return v.delete === 0;
            });
            return list.length;
        },
        imageMobileCount() {
            let list = _.filter(this.info.mobile_img_list, v => {
                return v.delete === 0;
            });
            return list.length;
        },
    },
    mounted() {
        this.getProductTypes().then(res => {
            this.select.product_types = res.data.data;
        });

        CKEDITOR.replace("content");
    },
    methods: {
        getProductTypes() {
            return new Promise(resolve => {
                axiosGetMethod('/product-type/list/all').then(res => {
                    resolve(res);
                });
            });
        },
        deletePicture(type, key, origin) {
            if (type == 'web') {
                origin ? this.info.web_img_list[key].delete = 1 : this.info.web_new_img_list = this.info.web_new_img_list.filter((v, k) => { return k != key; });
            } else if (type == 'mobile') {
                origin ? this.info.mobile_img_list[key].delete = 1 : this.info.mobile_new_img_list = this.info.mobile_new_img_list.filter((v, k) => { return k != key; }) ;
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
            this.value.keyword = '';

            this.info.id = null;
            this.info.product_types_id = '';
            this.info.title = '';
            this.info.content = '';
            this.info.keywords = [];
            this.info.description = '';
            this.info.product_front_cover_image_id = '';
            this.info.web_img_list = [];
            this.info.web_new_img_list = [];
            this.info.mobile_img_list = [];
            this.info.mobile_new_img_list = [];
            this.info.sales_status = '0';
            this.info.show_status = '0';
        },
        fileAuth(list, type) {
            let file_type = ['image/jpeg', 'image/png', 'image/gif'];
            let file_limit_size = 2097152;
            let file_limit_count = 5;

            let img_list = type === 'web' ? _.filter(this.info.web_img_list, v => { return v.delete === 0}) : _.filter(this.info.mobile_img_list, v => { return v.delete === 0});

            let length = type === 'web' ? img_list.length + this.info.web_new_img_list.length + list.length : img_list.length + this.info.mobile_new_img_list.length + list.length;
            if (length > file_limit_count) {
                return {status: false, message: `最多只能選擇${file_limit_count}個檔案`};
            }

            let type_error_count = 0;
            let limit_error_count = 0;

            for (let f = 0; f < list.length; f++) {
                if (!file_type.includes(list[f].type)) {
                    type_error_count++;
                }
                if (list[f].size > file_limit_size) {
                    limit_error_count++;
                }
            }

            if (type_error_count > 0) {
                return {status: false, message: '請選擇指定的檔案格式'};
            }

            if (limit_error_count > 0) {
                return {status: false, message: `檔案大小不得超過${file_limit_size / 1024 / 1024}MB`};
            }

            return {status: true};
        },
        file(e, type) {
            if (e.target && e.target.files.length > 0) {
                let { status, message } = this.fileAuth(e.target.files, type);
                if (!status) {
                    Toast.fire({icon: 'error', title: message});
                    return false;
                }

                for (let f = 0; f < e.target.files.length; f++) {
                    if (type === 'web') {
                        this.info.web_new_img_list.push(e.target.files[f]);
                    } else {
                        this.info.mobile_new_img_list.push(e.target.files[f]);
                    }
                }
            }
        },
        auth(data) {
            if (!data.product_types_id) {
                return {auth: false, message: '請選擇分類！'};
            }

            if (!data.title) {
                return {auth: false, message: '標題不得為空！'};
            }

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
            let url = this.mode === 'create' ? '/product/insert' : '/product/update';
            loading.show = true;

            let formData = new FormData;
            formData.append("id", this.info.id);
            formData.append("product_types_id", this.info.product_types_id);
            formData.append("title", this.info.title);
            formData.append("content", CKEDITOR.instances["content"].getData());
            formData.append("keywords", this.info.keywords);
            formData.append("description", this.info.description);

            formData.append("product_front_cover_image_id", this.info.product_front_cover_image_id);

            let delete_list = '';
            this.info.web_img_list.forEach((v, k) => {
                if(v.delete === 1){
                    delete_list += !delete_list ? v.id : ',' + v.id;
                }
            })
            formData.append("web_img_delete_list", delete_list);

            for (let f = 0; f < this.info.web_new_img_list.length; f++) {
                formData.append(`web_new_img_list[${f}]`, this.info.web_new_img_list[f]);
            }

            let mobile_delete_list = '';
            this.info.mobile_img_list.forEach((v, k) => {
                if(v.delete === 1){
                    mobile_delete_list += !mobile_delete_list ? v.id : ',' + v.id;
                }
            })
            formData.append("mobile_img_delete_list", mobile_delete_list);

            for (let f = 0; f < this.info.mobile_new_img_list.length; f++) {
                formData.append(`mobile_new_img_list[${f}]`, this.info.mobile_new_img_list[f]);
            }

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
        let obj = {
            id: null,
            product_id: null,
            name: '',
            original_price: null,
            selling_price: null,
            inventory: null,
            unit: null,
        };
        return {
            info: JSON.parse(JSON.stringify(obj)),
            modify_key: null,
            modify_info: JSON.parse(JSON.stringify(obj)),
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
            this.info.unit = null;
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

            if (!data.unit) {
                return {auth: false, message: '請輸入單位！'};
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
            this.modify_info.unit = this.list[key].unit;
            this.new_specification = false;
        },
        save() {
            let auth = this.auth(this.modify_info);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

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
