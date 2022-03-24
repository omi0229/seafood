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
            keywords: '',
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
        setKeywords(page) {
            this.search_text = this.keywords;
            this.getData(page);
        },
        getCount() {
            return new Promise(resolve => {
                let url = !this.search_text ? '/cooking/count' : '/cooking/count?keywords=' + this.search_text;
                axiosGetMethod(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page) {
            return new Promise(resolve => {
                let url = '/cooking/list/' + page;

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
            CKEDITOR.instances["description"].setData('');
            set_info.dataInit();
            set_info.mode = 'create';
        },
        modify(id) {
            set_info.dataInit();
            set_info.mode = 'modify';
            set_info.info.id = id;
            let info = _.find(this.list, {'id': id});
            set_info.info.cooking_types_id = info.cooking_types_id;
            set_info.info.title = info.title;
            set_info.info.start_date = info.start_date;
            set_info.info.end_date = info.end_date;

            $('input[data-target="#start_date"]').val(info.start_date.substr(0, 16));
            $('input[data-target="#end_date"]').val(info.end_date.substr(0, 16));

            set_info.info.href = info.href;
            CKEDITOR.instances["description"].setData(info.description);
            set_info.info.target = info.target;
            set_info.info.keywords = info.keywords ? info.keywords.split(',') : [];
            set_info.info.status = info.status;
            set_info.info.youtube_id = info.youtube_id;
            set_info.info.youtube_url = info.youtube_url;
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
    },
}).mount('#app');

let set_info = createApp({
    data() {
        return {
            mode: 'create',
            date: new Date(),
            info: {
                id: '',
                cooking_types_id: '',
                title: '',
                start_date: '',
                end_date: '',
                href: '',
                target: '0',
                keywords: [],
                status: '0',
                youtube_id: '',
                youtube_url: '',
            },
            value: {
                keyword: '',
            },
            select: {
                cooking_types: [],
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

        this.getCookingTypes().then(res => {
            this.select.cooking_types = res.data.data;
        });

        CKEDITOR.replace("description");
    },
    methods: {
        getCookingTypes() {
            return new Promise(resolve => {
                axiosGetMethod('/cooking-type/list/all').then(res => {
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

            this.value.keyword = '';

            this.info.id = null;
            this.info.cooking_types_id = '';
            this.info.title = '';
            this.info.start_date = '';
            this.info.end_date = '';
            this.info.href = '';
            this.info.target = '0';
            this.info.keywords = [];
            this.info.status = '0';
            this.info.youtube_id = '';
            this.info.youtube_url = '';
        },
        auth(data) {
            if (!data.cooking_types_id) {
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

            if (!data.youtube_url) {
                return {auth: false, message: 'youtube網址不得為空！'};
            }

            try {
                let url = new URL(data.youtube_url);



                let params = url.searchParams;
                if (!((url.host + url.pathname == 'www.youtube.com/watch' && params.get('v')) || (url.host == 'youtu.be' && url.pathname.substr(1)) || (url.host == 'www.youtube.com' && url.pathname.substr(0, 7) == '/embed/' && url.pathname.substr(7)))) {
                    return {auth: false, message: 'youtube網址格式錯誤！'};
                }
            } catch (e) {
                return {auth: false, message: 'youtube網址格式錯誤！'};
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
            let url = this.mode === 'create' ? '/cooking/insert' : '/cooking/update';
            loading.show = true;

            let youtube_url = new URL(this.info.youtube_url);

            if (youtube_url.host + youtube_url.pathname == 'www.youtube.com/watch') {
                let params = youtube_url.searchParams;
                this.info.youtube_id = params.get('v');
            } else if (youtube_url.host == 'youtu.be') {
                this.info.youtube_id = youtube_url.pathname.substr(1);
            } else if (youtube_url.host == 'www.youtube.com' && youtube_url.pathname.substr(0, 7) == '/embed/' && youtube_url.pathname.substr(7)){
                this.info.youtube_id = youtube_url.pathname.substr(7);
            }

            axiosPostMethod(url, this.info).then(async res => {
                res.data.status ? $('#set-info').modal('hide') : null;

                await app.searchService();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            });
        },
    },
}).mount('#set-info');
