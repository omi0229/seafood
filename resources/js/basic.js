import { swal2Confirm } from './bootstrap';

window.app = createApp({
    data() {
        return {
            mode: 'basic',
            config: {
                basic: {
                    basic_title: '',
                    basic_company: '',
                    basic_phone: '',
                    basic_address: '',
                    basic_email: '',
                },
                goldflow: {
                    goldflow_MerchantID: '',
                    goldflow_HashKey: '',
                    goldflow_HashIV: '',
                },
                seo: {
                    seo_keyword: '',
                    seo_description: '',
                },
                link: {
                    link_youtube: '',
                    link_facebook: '',
                    link_instagram: '',
                    link_line: '',
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
                    case 'basic_company':
                        this.config.basic.basic_company = v.config_value;
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
                    case 'goldflow_MerchantID':
                        this.config.goldflow.goldflow_MerchantID = v.config_value;
                        break;
                    case 'goldflow_HashKey':
                        this.config.goldflow.goldflow_HashKey = v.config_value;
                        break;
                    case 'goldflow_HashIV':
                        this.config.goldflow.goldflow_HashIV = v.config_value;
                        break;
                    case 'seo_keyword':
                        this.config.seo.seo_keyword = v.config_value;
                        break;
                    case 'seo_description':
                        this.config.seo.seo_description = v.config_value;
                        break;
                    case 'link_youtube':
                        this.config.link.link_youtube = v.config_value;
                        break;
                    case 'link_facebook':
                        this.config.link.link_facebook = v.config_value;
                        break;
                    case 'link_instagram':
                        this.config.link.link_instagram = v.config_value;
                        break;
                    case 'link_line':
                        this.config.link.link_line = v.config_value;
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
                case 'link':
                    obj = this.config.link;
                    break;
            }

            loading.show = true;
            axios.post('/basic/set', obj).then(async res => {
                loading.show = false;
                if (res.data.status) {
                    Toast.fire({icon: 'success', title: '儲存完成'});
                } else {
                    Toast.fire({icon: 'error', title: res.data.message});
                }
            }).catch(error => {
                loading.show = false;
                Toast.fire({icon: 'error', title: '儲存失敗'});
            });
        },
    },
}).mount('#app');
