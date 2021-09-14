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
                let url = !this.search_text ? '/news/count' : '/news/count?keywords=' + this.search_text;
                axios.get(url).then(res => {
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
            set_info.info.href = info.href;
            set_info.info.description = info.description;
            set_info.info.target = info.target;
            set_info.info.keywords = info.keywords.split(',');
            set_info.info.status = info.status;
            set_info.info.web_img_name = info.web_img_name;
            set_info.info.web_img = '';
            set_info.info.mobile_img_name = info.mobile_img_name;
            set_info.info.mobile_img = '';
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/news/delete', {data: this.check}).then(async res => {
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
            swal2Confirm('確定刪除選取的權限？').then(confirm => {
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
                description: '',
                target: '0',
                keywords: [],
                status: '0',
                web_img_name: '請選擇檔案',
                mobile_img_name: '請選擇檔案',
                web_img: '',
                mobile_img: '',
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
    },
    methods: {
        getNewsTypes() {
            return new Promise(resolve => {
                axios.get('/news-type/list/all').then(res => {
                    resolve(res);
                });
            });
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


            this.info.id = null;
            this.info.news_types_id = '';
            this.info.title = '';
            this.info.start_date = '';
            this.info.end_date = '';
            this.info.href = '';
            this.info.description = '';
            this.info.target = '0';
            this.info.keywords = [];
            this.info.status = '0';
            this.info.web_img_name = '';
            this.info.web_img = null;
            this.info.mobile_img_name = '';
            this.info.mobile_img = null;
        },
        file(e, type) {
            if (e.target && e.target.files[0]) {
                if (type == 'web') {
                    this.info.web_img_name = e.target.files[0].name;
                    this.info.web_img = e.target.files[0];

                } else if (type == 'mobile') {
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
            formData.append("description", this.info.description);
            formData.append("target", this.info.target);
            formData.append("keywords", this.info.keywords);
            formData.append("status", this.info.status);
            formData.append("web_img_name", this.info.web_img_name);
            formData.append("mobile_img_name", this.info.mobile_img_name);
            formData.append("web_img", this.info.web_img);
            formData.append("mobile_img", this.info.mobile_img);

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
