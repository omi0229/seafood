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
    computed: {
        dateFormat() {
            return datetime => {
                return moment(datetime).format('Y-MM-DD HH:mm');
            }
        },
        targetFormat() {
            return target => {
                return target ? '開新視窗' : '直接開啟';
            }
        },
        statusFormat() {
            return status => {
                return status ? '顯示' : '不顯示';
            }
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
                axios.get(url).then(res => {
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
            set_info.info.web_img_name = info.web_img_name || '請選擇檔案';
            set_info.info.web_img = '';
            set_info.info.web_img_path = info.web_img_path;
            set_info.info.mobile_img_name = info.mobile_img_name || '請選擇檔案';
            set_info.info.mobile_img = '';
            set_info.info.mobile_img_path = info.mobile_img_path;
            set_info.info.sales_status = info.sales_status;
            set_info.info.show_status = info.show_status;
        },
        specification(id) {
            set_specification.dataInit();
            set_specification.info.product_id = id;
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/product/delete', {data: this.check}).then(async res => {
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
                web_img_delete: 0,
                web_img_name: '請選擇檔案',
                web_img: '',
                web_img_path: '',
                mobile_img_delete: 0,
                mobile_img_name: '請選擇檔案',
                mobile_img: '',
                mobile_img_path: '',
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
    mounted() {
        this.getProductTypes().then(res => {
            this.select.product_types = res.data.data;
        });

        CKEDITOR.replace("content");
    },
    methods: {
        getProductTypes() {
            return new Promise(resolve => {
                axios.get('/product-type/list/all').then(res => {
                    resolve(res);
                });
            });
        },
        deletePicture(type) {
            if (type == 'web') {
                this.info.web_img_delete = 1;
                this.info.web_img_name = '請選擇檔案';
                this.info.web_img = '';
                this.$refs.web_img.value = '';
            } else if (type == 'mobile') {
                this.info.mobile_img_delete = 1;
                this.info.mobile_img_name = '請選擇檔案';
                this.info.mobile_img = '';
                this.$refs.mobile_img.value = '';
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
            this.info.web_img_delete = 0;
            this.info.web_img_name = '請選擇檔案';
            this.info.web_img = null;
            this.info.web_img_path = '';
            this.info.mobile_img_delete = 0;
            this.info.mobile_img_name = '請選擇檔案';
            this.info.mobile_img = null;
            this.info.mobile_img_path = '';
            this.info.sales_status = '0';
            this.info.show_status = '0';
        },
        file(e, type) {
            if (e.target && e.target.files[0]) {
                if (type == 'web') {
                    this.info.web_img_delete = 0;
                    this.info.web_img_name = e.target.files[0].name;
                    this.info.web_img = e.target.files[0];

                } else if (type == 'mobile') {
                    this.info.mobile_img_delete = 0;
                    this.info.mobile_img_name = e.target.files[0].name;
                    this.info.mobile_img = e.target.files[0];
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
            }

            axios.post(url, formData, config).then(async res => {
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
            }
        }
    },
    delimiters: ["${", "}"],
    mounted() {

    },
    methods: {
        dataInit() {
            this.info.id = null;
            this.info.product_id = null;
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
            let auth = this.auth(this.info);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let text = mode === 'create' ? '新增' : '編輯';

            swal2Confirm(`確定${text}此規格？`).then(confirm => {
                if (confirm) {
                    this.create();
                }
            });
        },
        create() {
            axios.post('/product-specification/insert', this.info).then(async res => {
                this.dataInit();
                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            }).catch(error => {

            });
        },
    },
}).mount('#set-specification');
