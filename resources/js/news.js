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
                let url = !this.search_text ? '/news/count' : '/news/count?keywords=' + this.search_text;
                axiosGetMethod(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = '/news/list/' + page;

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
            CKEDITOR.instances["description"].setData('');
            set_info.dataInit();
            set_info.mode = 'create';
        },
        modify(id) {
            set_info.dataInit();
            set_info.mode = 'modify';
            set_info.info.id = id;
            let info = _.find(this.list, {'id': id});
            set_info.info.news_types_id = info.news_types_id;
            set_info.info.title = info.title;
            set_info.info.start_date = info.start_date;
            set_info.info.end_date = info.end_date;

            $('input[data-target="#start_date"]').val(info.start_date.substr(0, 16));
            $('input[data-target="#end_date"]').val(info.end_date.substr(0, 16));

            set_info.info.href = info.href;
            CKEDITOR.instances["description"].setData(info.description);
            set_info.info.target = info.target;
            set_info.info.keywords = info.keywords ? info.keywords.split(',') : [];
            set_info.info.carousel = info.carousel;
            set_info.info.status = info.status;
            set_info.info.web_img_name = info.web_img_name || '請選擇檔案';
            set_info.info.web_img = '';
            set_info.info.web_img_path = info.web_img_path;
            set_info.info.mobile_img_name = info.mobile_img_name || '請選擇檔案';
            set_info.info.mobile_img = '';
            set_info.info.mobile_img_path = info.mobile_img_path;
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axiosDeleteMethod('/news/delete', {data: this.check}).then(async res => {
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
                news_types_id: '',
                title: '',
                start_date: '',
                end_date: '',
                href: '',
                target: '0',
                keywords: [],
                carousel: '0',
                status: '0',
                web_img_delete: 0,
                web_img_name: '請選擇檔案',
                web_img: '',
                web_img_path: '',
                mobile_img_delete: 0,
                mobile_img_name: '請選擇檔案',
                mobile_img: '',
                mobile_img_path: '',
            },
            value: {
                keyword: '',
            },
            select: {
                news_types: [],
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

        this.getNewsTypes().then(res => {
            this.select.news_types = res.data.data;
        });

        CKEDITOR.replace("description");
    },
    methods: {
        getNewsTypes() {
            return new Promise(resolve => {
                axiosGetMethod('/news-type/list/all').then(res => {
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
            $('input[data-target="#start_date"]').datetimepicker('clear');
            $('input[data-target="#end_date"]').datetimepicker('clear');

            this.value.keyword = '';

            this.info.id = null;
            this.info.news_types_id = '';
            this.info.title = '';
            this.info.start_date = '';
            this.info.end_date = '';
            this.info.href = '';
            this.info.target = '0';
            this.info.keywords = [];
            this.info.carousel = '0';
            this.info.status = '0';
            this.info.web_img_delete = 0;
            this.info.web_img_name = '請選擇檔案';
            this.info.web_img = null;
            this.$refs.web_img.value = null;
            this.info.web_img_path = '';
            this.info.mobile_img_delete = 0;
            this.info.mobile_img_name = '請選擇檔案';
            this.info.mobile_img = null;
            this.$refs.mobile_img.value = null;
            this.info.mobile_img_path = '';
        },
        fileAuth(list, type) {
            let file_type = ['image/jpeg', 'image/png', 'image/gif'];
            let file_limit_size = 2097152;

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
                type === 'web' ? this.$refs.web_img.value = '' : this.$refs.mobile_img.value = '';
                return {status: false, message: '請選擇指定的檔案格式'};
            }

            if (limit_error_count > 0) {
                type === 'web' ? this.$refs.web_img.value = '' : this.$refs.mobile_img.value = '';
                return {status: false, message: `檔案大小不得超過${file_limit_size / 1024 / 1024}MB`};
            }

            return {status: true};
        },
        file(e, type) {
            let {status, message} = this.fileAuth(e.target.files, type);
            if (!status) {
                Toast.fire({icon: 'error', title: message});
                return false;
            }

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
            if (!data.news_types_id) {
                return {auth: false, message: '請選擇分類！'};
            }

            if (!data.title) {
                return {auth: false, message: '標題不得為空！'};
            }

            let start_date = $('input[data-target="#start_date"]').val();
            let end_date = $('input[data-target="#end_date"]').val();

            if (!start_date) {
                return {auth: false, message: '請選擇開始日期！'};
            }

            if (!end_date) {
                return {auth: false, message: '請選擇結束日期！'};
            }

            if (start_date >= end_date) {
                return {auth: false, message: '日期格式或日期範圍錯誤！'};
            }

            data.start_date = start_date;
            data.end_date = end_date;

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
            let url = this.mode === 'create' ? '/news/insert' : '/news/update';
            loading.show = true;
            let formData = new FormData;
            formData.append("id", this.info.id);
            formData.append("news_types_id", this.info.news_types_id);
            formData.append("title", this.info.title);
            formData.append("start_date", this.info.start_date);
            formData.append("end_date", this.info.end_date);
            formData.append("href", this.info.href);
            formData.append("description", CKEDITOR.instances["description"].getData());
            formData.append("target", this.info.target);
            formData.append("keywords", this.info.keywords);
            formData.append("carousel", this.info.carousel);
            formData.append("status", this.info.status);
            formData.append("web_img_delete", this.info.web_img_delete);
            formData.append("web_img_name", this.info.web_img_name);
            formData.append("web_img", this.info.web_img);
            formData.append("mobile_img_delete", this.info.mobile_img_delete);
            formData.append("mobile_img_name", this.info.mobile_img_name);
            formData.append("mobile_img", this.info.mobile_img);

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }

            axiosPostMethod(url, formData, config).then(async res => {
                res.data.status ? $('#set-info').modal('hide') : null;

                await app.searchService();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            });
        },
    },
}).mount('#set-info');
