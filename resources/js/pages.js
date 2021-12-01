import moment from 'moment';
import {swal2Confirm} from './bootstrap';

window.app = createApp({
    data() {
        return {
            list: [],
        }
    },
    delimiters: ["${", "}"],
    computed: {
        dateFormat() {
            return datetime => {
                return moment(datetime).format('Y-MM-DD HH:mm');
            }
        },
    },
    async mounted() {
        await this.getData();
    },
    methods: {
        getData() {
            return new Promise(resolve => {
                let url = '/pages/list';
                axiosGetMethod(url).then(res => {
                    app.list = res.data.data;
                    if (loading && loading.show) {
                        loading.show = false;
                    }
                    resolve();
                });
            });
        },
        modify(type) {
            set_info.dataInit();
            set_info.info.type = type;
            let info = _.find(this.list, {'type': type});
            set_info.info.name = info.name;
            CKEDITOR.instances["content"].setData(info.content);
        },
    },
}).mount('#app');

let set_info = createApp({
    data() {
        return {
            date: new Date(),
            info: {
                type: '',
                name: '',
                content: '',
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        CKEDITOR.replace("content");
    },
    methods: {
        dataInit() {
            this.info.type = '';
            this.info.name = '';
            this.info.content = '';
        },
        confirm() {
            swal2Confirm(`確定編輯完成？`).then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            loading.show = true;
            this.info.content = CKEDITOR.instances["content"].getData();
            let obj = { type: this.info.type, content: this.info.content }
            axios.post('/pages/update', obj).then(async res => {
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
