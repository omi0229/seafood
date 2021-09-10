import { swal2Confirm } from './bootstrap';

window.app = createApp({
    data() {
        return {
            config: {
                sms: {
                    sms_account: '',
                    sms_password: '',
                },
            },
            points: 5000,
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        this.getConfig().then(res => {
            _.forEach(res.data.data, (v, k) => {
                switch (v.config_name) {
                    case 'sms_account':
                        this.config.sms.sms_account = v.config_value;
                        break;
                    case 'sms_password':
                        this.config.sms.sms_password = v.config_value;
                        break;
                }
            });
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
        confirm() {
            swal2Confirm('儲存設定？').then(confirm => {
                if (confirm) {
                    this.save();
                }
            });
        },
        save() {
            loading.show = true;
            axios.post('/sms/set', this.config.sms).then(async res => {
                loading.show = false;
                Toast.fire({icon: 'success', title: '儲存完成'});
            }).catch(error => {
                loading.show = false;
                Toast.fire({icon: 'error', title: '儲存失敗'});
            });
        },
    },
}).mount('#app');
