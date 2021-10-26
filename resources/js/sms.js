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
            points: 0,
        }
    },
    delimiters: ["${", "}"],
    mounted() {
        this.getConfig().then(async res => {
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

            await this.__queryPoints().then(res => {

                console.log(res.data);

                if (res.data.status) {
                    this.points = res.data.data.ReturnDouble;
                }
            });

            loading.show = false;
        });
    },
    methods: {
        getConfig() {
            return new Promise(resolve => {
                axiosGetMethod('/basic/get').then(res => {
                    resolve(res);
                });
            });
        },
        __queryPoints() {
            return new Promise(resolve => {
                axiosPostMethod('/sms/query-points', this.config.sms).then(res => {
                    resolve(res);
                })
            })
        },
        async queryPoints() {
            loading.show = true;
            await this.__queryPoints().then(res => {
                if (res.data.status) {
                    this.points = res.data.data.ReturnDouble;
                }

                loading.show = false;

                let icon = res.data.status ? 'success' : 'error';
                Toast.fire({icon: icon, title: res.data.message});
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
