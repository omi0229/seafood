import { swal2Confirm } from './bootstrap';
import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";

window.app = createApp({
    data() {
        return {
            checkAll: false,
            check: [],
            list: [],
        }
    },
    delimiters: ["${", "}"],
    watch: {
        'checkAll'(newData, oldData) {
            this.check = newData ? _.map(this.list, 'id') : [];
        },
    },
    computed: {
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
        await this.getData();
    },
    methods: {
        getData() {
            return new Promise(resolve => {
                let url = '/banners/list';
                axiosGetMethod(url).then(res => {
                    app.check = [];
                    app.checkAll = false;
                    app.list = res.data.data;
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
            set_info.info.href = info.href || '';
            set_info.info.target = info.target;
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
                axios.delete('/banners/delete', {data: this.check}).then(async res => {
                    if (res.data.status) {
                        Toast.fire({icon: 'success', title: '刪除成功'});
                        await this.getData();
                    }
                });
            }
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
                href: '',
                target: '0',
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
        }
    },
    delimiters: ["${", "}"],
    mounted() {},
    methods: {
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
        dataInit() {
            this.info.id = null;
            this.info.href = '';
            this.info.target = '0';
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
            let file_limit_size = 5242880;

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
            if (this.mode == 'create') {
                if (!data.web_img) {
                    return {auth: false, message: '請選擇一張網頁版圖片！'};
                }

                if (!data.mobile_img) {
                    return {auth: false, message: '請選擇一張手機版圖片！'};
                }
            } else if (this.mode == 'modify') {
                if (data.web_img_delete === 1) {
                    return {auth: false, message: '請選擇一張網頁版圖片！'};
                }

                if (data.mobile_img_delete === 1) {
                    return {auth: false, message: '請選擇一張手機版圖片！'};
                }
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
            let url = this.mode === 'create' ? '/banners/insert' : '/banners/update';
            loading.show = true;
            let formData = new FormData;

            if (this.mode === 'modify') {
                formData.append("id", this.info.id);
            }

            formData.append("href", this.info.href);
            formData.append("target", this.info.target);
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

            axios.post(url, formData, config).then(async res => {
                if (res.data.status) {
                    $('#set-info').modal('hide');
                }

                await app.getData();

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
            }).catch(error => {

            });
        },
    },
}).mount('#set-info');
