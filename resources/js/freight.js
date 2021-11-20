import moment from 'moment';
import { find } from 'lodash';
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
            this.check = [];
            if (newData) {
                this.list.forEach(v => {
                    let start = moment(v.start_date).valueOf();
                    let now = moment().valueOf();
                    let end = moment(v.end_date).valueOf();
                    if (!(start <= now && end >= now)) {
                        this.check.push(v.id);
                    }
                })
            }
        },
    },
    computed: {
        dateFormat() {
            return datetime => {
                return moment(datetime).format('Y-MM-DD');
            }
        },
        dateAuth() {
            return (start_date, end_date) => {
                let start = moment(start_date).valueOf();
                let now = moment().valueOf();
                let end = moment(end_date).valueOf();
                if (start <= now && end >= now) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    },
    mounted() {
        this.getCount(1);
        this.getData(1, 1).then(res => {
            this.list = res.data.data;
            if (loading && loading.show) {
                loading.show = false;
            }
        });
    },
    methods: {
        getCount(floor) {
            return new Promise(resolve => {
                let url = '/freight/count';
                url += '?floor=' + floor;
                url += this.search_text ? '&keywords=' + this.search_text : '';
                axios.get(url).then(res => {
                    this.all_count = res.data.count;
                    this.page_count = res.data.page_count;
                    resolve();
                });
            });
        },
        getData(page, floor = 1) {
            return new Promise(resolve => {
                let url = '/freight/list/' + page;
                url += '?floor=' + floor;
                url += this.search_text ? '&keywords=' + this.search_text : '';
                axiosGetMethod(url).then(res => {
                    resolve(res);
                });
            });
        },
        async getFloor1Data(page, floor = 1) {
            await this.getData(page, floor).then(res => {
                this.list = res.data.data;
                if (loading && loading.show) {
                    loading.show = false;
                }
            });
            await this.getCount(floor);
        },
        create() {
            set_info.dataInit();
            set_info.mode = 'create';
        },
        modify(id) {
            set_info.dataInit();
            set_info.mode = 'modify';
            set_info.freight.id = id;
            let info = _.find(this.list, {'id': id});
            set_info.freight.title = info.title;
            set_info.freight.default = info.default;
            set_info.freight.start_date = info.start_date;
            set_info.freight.end_date = info.end_date;

            $('input[data-target="#start_date"]').val(info.start_date.substr(0, 10));
            $('input[data-target="#end_date"]').val(info.end_date.substr(0, 10));
        },
        delete() {
            if(this.check.length > 0) {
                loading.show = true;
                axios.delete('/freight/delete', {data: this.check}).then(async res => {
                    let icon = res.data.status ? 'success' : 'error';
                    Toast.fire({icon: icon, title: res.data.message});

                    res.data.status ?　this.searchService('delete') :　loading.show = false;
                });
            }
        },
        searchService(type = null) {
            return new Promise(async resolve => {
                await this.getCount(1);
                await this.getData(this.$refs.pagination.page, 1).then(res => {
                    this.list = res.data.data;
                    if (loading && loading.show) {
                        loading.show = false;
                    }
                });
                if (this.$refs.pagination.page > 1 && this.list.length === 0) {
                    if (type === 'delete' || this.search_text) {
                        loading.show = true;
                        await this.getData(1, 1).then(res => {
                            this.list = res.data.data;
                            if (loading && loading.show) {
                                loading.show = false;
                            }
                        });
                        this.$refs.pagination.setPage(1);
                    }
                }

                resolve();
            });
        },
        confirm() {
            swal2Confirm('確定刪除選取的分類？').then(confirm => {
                if (confirm) {
                    this.delete();
                }
            });
        },
        floor2(id) {
            set_floor2.freight2.parents_id = id;
            let freight1 = find(this.list, ['id', id]);
            set_floor2.freight1_title = freight1.title;
            set_floor2.getParentsList(id).then(res => {
                set_floor2.list = res.data.data;
            })

            set_floor2.select.floor1 = [];
            this.list.forEach(v => {
                set_floor2.select.floor1.push({ id: v.id, title: v.title });
            })

            set_floor2.checkAll = false;
            set_floor2.check = [];
            set_floor2.modify_key = null;

            // 以下第三層設定
            set_floor2.modify_floor3_parents_id = null;

            set_floor2.floor3.select.floor_type = [];
            this.getData('all', 1).then(res => {
                res.data.data.forEach(v => {
                    v.children.forEach(v2 => {
                        set_floor2.floor3.select.floor_type.push({
                            id: v2.id,
                            title: v.title + ' - ' + v2.title,
                        })
                    })
                })
            })
        }
    },
}).mount('#app');

let set_info = createApp({
    data() {
        return {
            mode: 'create',
            freight: {
                id: '',
                floor: 1,
                title: '',
                default: '0',
                start_date: '',
                end_date: '',
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {

        let datetimepicker_obj = {
            locale: 'zh-tw',
            format: 'YYYY-MM-DD',
            icons: {time: 'far fa-clock'},
        };

        $('#start_date').datetimepicker(datetimepicker_obj);
        $('#end_date').datetimepicker(datetimepicker_obj);

    },
    methods: {
        dataInit() {
            $('input[data-target="#start_date"]').datetimepicker('clear');
            $('input[data-target="#end_date"]').datetimepicker('clear');

            this.checkAll = false;
            this.freight.id = '';
            this.freight.floor = 1;
            this.freight.title = '';
            this.freight.start_date = '';
            this.freight.end_date = '';
        },
        auth(data) {
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

            if (start_date > end_date) {
                return {auth: false, message: '日期格式或日期範圍錯誤！'};
            }

            data.start_date = start_date;
            data.end_date = end_date;

            return {auth: true, message: 'success'};
        },
        confirm() {
            let auth = this.auth(this.freight);
            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let text = this.mode === 'create' ? '新增' : '編輯';

            swal2Confirm(`確定${text}此運費類型？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let url = this.mode === 'create' ? '/freight/insert' : '/freight/update';
            loading.show = true;
            axiosPostMethod(url, this.freight).then(async res => {
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

let set_floor2 = createApp({
    data() {
        return {
            mode: 'create',
            freight1_title: '',
            freight2: {
                id: null,
                floor: 2,
                parents_id: '',
                status: '1',
                sort: null,
                title: '',
            },
            modify_freight2: {
                id: null,
                floor: 2,
                parents_id: '',
                status: '1',
                sort: null,
                title: '',
            },
            list: [],
            checkAll: false,
            modify_key: null,
            check: [],
            select: {
                floor1: [],
            },
            // 以下第三層
            modify_floor3_parents_id: null,
            floor3: {
                list: [],
                checkAll: false,
                modify_key: null,
                check: [],
                select: {
                    floor_type: [],
                },
            },
            freight3: {
                id: null,
                floor: 3,
                parents_id: '',
                start_total: 0,
                end_total: 0,
                freight: 0,
            },
            modify_freight3: {
                id: null,
                floor: 3,
                parents_id: '',
                start_total: 0,
                end_total: 0,
                freight: 0,
            },
        }
    },
    delimiters: ["${", "}"],
    methods: {
        checkAllChange(floor = null) {
            if(floor === 3) {
                this.floor3.check = this.floor3.checkAll ? _.map(this.floor3.list, 'id') : [];
            } else {
                this.check = this.checkAll ? _.map(this.list, 'id') : [];
            }
        },
        getParentsList(parents_id) {
            return new Promise(resolve => {
                axiosGetMethod('freight/list/parents/' + parents_id).then(res => {
                    resolve(res);
                });
            })
        },
        dataInit(floor = null) {
            if(floor === 3) {
                this.floor3.checkAll = false;
                this.floor3.check = [];
                this.floor3.modify_key = null;
                this.freight3.start_total = 0;
                this.freight3.end_total = 0;
                this.freight3.freight = 0;
            } else {
                this.checkAll = false;
                this.check = [];
                this.modify_key = null;
                this.freight2.id = null;
                this.freight2.status = '1';
                this.freight2.sort = null;
                this.freight2.title = '';
            }
        },
        auth(data) {
            if (!data.sort) {
                return {auth: false, message: '請輸入排序數字！'};
            }

            if (isNaN(data.sort)) {
                return {auth: false, message: '排序欄位請輸入數字！'};
            }

            if (!data.title) {
                return {auth: false, message: '請輸入標題！'};
            }

            return {auth: true, message: 'success'};
        },
        confirm(mode, floor = 2) {
            this.mode = mode;

            if(floor === 3) { // 驗證第三層
                if (mode === 'create' || mode === 'modify') {
                    let auth = this.authFloor3(this.freight3);
                    if (!auth.auth) {
                        Toast.fire({icon: 'error', title: auth.message});
                        return false;
                    }
                }
            } else { // 驗證第二層
                if (mode === 'create' || mode === 'modify') {
                    let auth = this.auth(this.freight2);
                    if (!auth.auth) {
                        Toast.fire({icon: 'error', title: auth.message});
                        return false;
                    }
                }
            }

            let text = '';
            switch (mode) {
                case 'create':
                    text = '確定新增此項目？';
                    break;
                case 'modify':
                    text = '確定編輯此項目？';
                    break;
                case 'delete':
                    text = '確定刪除選取的項目？';
                    break;
            }

            swal2Confirm(text).then(confirm => {
                if (confirm) {
                    switch (mode) {
                        case 'create':
                            this.create(floor);
                            break;
                        case 'modify':
                            this.save();
                            break;
                        case 'delete':
                            this.delete(floor);
                            break;
                    }
                }
            });
        },
        delete(floor = null) {
            let check = floor === 3 ? this.floor3.check : this.check;
            if(check.length > 0) {
                loading.show = true;
                axios.delete('/freight/delete', {data: check}).then(async res => {
                    if(res.data.status) {
                        if (floor === 3) {
                            this.getParentsList(this.freight3.parents_id).then(res => {
                                this.floor3.list = res.data.data;
                            })
                            this.dataInit(floor);
                        } else {
                            await this.getParentsList(this.freight2.parents_id).then(res => {
                                this.list = res.data.data;
                            })
                            this.dataInit();
                        }
                    }

                    loading.show = false;
                    let icon = res.data.status ? 'success' : 'error';
                    Toast.fire({icon: icon, title: res.data.message});
                });
            }
        },
        create(floor) {
            let data = floor === 3 ? this.freight3 : this.freight2;
            let url = this.mode === 'create' ? '/freight/insert' : '/freight/update';
            loading.show = true;
            axiosPostMethod(url, data).then(async res => {
                if (res.data.status) {
                    if (floor === 3) {
                        this.getParentsList(this.freight3.parents_id).then(res => {
                            this.floor3.list = res.data.data;
                        })
                        this.dataInit(floor);
                    } else {
                        await this.getParentsList(this.freight2.parents_id).then(res => {
                            this.list = res.data.data;
                        })
                        this.dataInit();
                    }
                }

                loading.show = false;
                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            });
        },
        modify(key, floor = null) {
            if(floor === 3) {
                this.floor3.modify_key = key;
                this.modify_freight3.id = this.floor3.list[key].id;
                this.modify_freight3.parents_id = this.floor3.list[key].parents_id;
                this.modify_freight3.start_total = this.floor3.list[key].start_total;
                this.modify_freight3.end_total = this.floor3.list[key].end_total;
                this.modify_freight3.freight = this.floor3.list[key].freight;
            } else {
                this.modify_key = key;
                this.modify_freight2.id = this.list[key].id;
                this.modify_freight2.parents_id = this.freight2.parents_id;
                this.modify_freight2.status = this.list[key].status;
                this.modify_freight2.sort = this.list[key].sort;
                this.modify_freight2.title = this.list[key].title;

                this.modify_floor3_parents_id = null;
            }
        },
        save(floor = null) {

            let auth;
            if (floor === 3) {
                auth = this.authFloor3(this.modify_freight3);
            } else {
                auth = this.auth(this.modify_freight2);
            }

            if (!auth.auth) {
                Toast.fire({icon: 'error', title: auth.message});
                return false;
            }

            let data = floor === 3 ? this.modify_freight3 : this.modify_freight2;
            swal2Confirm(`確定變更項目資料？`).then(confirm => {
                if (confirm) {
                    loading.show = true;
                    axiosPostMethod('/freight/update', data).then(async res => {
                        if (res.data.status) {
                            let parents_id = floor === 3 ? this.freight3.parents_id : this.freight2.parents_id;
                            this.getParentsList(parents_id).then(res => {
                                floor === 3 ? this.floor3.list = res.data.data : this.list = res.data.data;
                            })
                            floor === 3 ? this.floor3.modify_key = null : this.modify_key ;
                        }

                        let icon = res.data.status ? 'success' : 'error';

                        loading.show = false;
                        Toast.fire({icon: icon, title: res.data.message});
                    });
                }
            });
        },
        cancel(floor = null) {
            floor === 3 ? this.floor3.modify_key = null : this.modify_key = null;
        },
        setFloor3(id) {
            if (this.modify_floor3_parents_id === id) {
                this.modify_floor3_parents_id = null;
                return true;
            }

            this.dataInit(3);

            loading.show = true;
            this.modify_floor3_parents_id = id;
            this.freight3.parents_id = id;

            this.getParentsList(id).then(res => {
                this.floor3.list = res.data.data;
                loading.show = false;
            })
        },
        authFloor3(data) {
            if (!data.start_total && data.start_total !== 0) {
                return {auth: false, message: '請輸入 金額起始範圍！'};
            }

            if (isNaN(data.start_total)) {
                return {auth: false, message: '金額起始範圍請 輸入數字！'};
            }

            if (!data.end_total && data.end_total !== 0) {
                return {auth: false, message: '請輸入 金額結束範圍！'};
            }

            if (isNaN(data.end_total)) {
                return {auth: false, message: '金額結束範圍 請輸入數字！'};
            }

            if (data.end_total < data.start_total) {
                return {auth: false, message: '金額起始範圍 不得大於 金額結束範圍！'};
            }

            if (!data.freight && data.freight !== 0) {
                return {auth: false, message: '請輸入 運費！'};
            }

            if (isNaN(data.freight)) {
                return {auth: false, message: '運費 請輸入數字！'};
            }

            return { auth: true, message: 'success' };
        },
    },
}).mount('#set-floor2');
