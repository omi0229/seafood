import { swal2Confirm } from './bootstrap';

window.app = createApp({
    data() {
        return {
            mode: 'basic',
            config: {
                basic: {
                    basic_title: '',
                    basic_phone: '',
                    basic_address: '',
                    basic_email: '',
                    basic_facebook: '',
                    basic_line: '',
                },
                goldflow: {},
                seo: {
                    seo_keyword: '',
                    seo_description: '',
                },
            },
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        this.getConfig().then(res => {
            _.forEach(res.data.data, (v, k) => {
                switch (v.config_name) {
                    case 'basic_title':
                        this.config.basic.basic_title = v.config_value;
                        break;
                    case 'basic_phone':
                        this.config.basic.basic_phone = v.config_value;
                        break;
                    case 'basic_address':
                        this.config.basic.basic_address = v.config_value;
                        break;
                    case 'basic_email':
                        this.config.basic.basic_email = v.config_value;
                        break;
                    case 'basic_facebook':
                        this.config.basic.basic_facebook = v.config_value;
                        break;
                    case 'basic_line':
                        this.config.basic.basic_line = v.config_value;
                        break;
                    case 'seo_keyword':
                        this.config.seo.seo_keyword = v.config_value;
                        break;
                    case 'seo_description':
                        this.config.seo.seo_description = v.config_value;
                        break;
                }
            })
            loading.show = false;
        });
    },
    methods: {
        getConfig() {
            return new Promise(resolve => {
                axios.get('/basic/get').then(res => {
                    resolve(res);
                });
            });
        },
        setMode(mode) {
            this.mode = mode;
        },
        confirm() {
            swal2Confirm('儲存設定？').then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            let obj;
            switch (this.mode) {
                case 'basic':
                    obj = this.config.basic;
                    break;
                case 'goldflow':
                    obj = this.config.goldflow;
                    break;
                case 'seo':
                    obj = this.config.seo;
                    break;
            }

            loading.show = true;
            axios.post('/basic/set', obj).then(async res => {
                loading.show = false;
                Toast.fire({icon: 'success', title: '儲存完成'});
            }).catch(error => {
                loading.show = false;
                Toast.fire({icon: 'error', title: '儲存失敗'});
            });
        },
    },
}).mount('#app');
