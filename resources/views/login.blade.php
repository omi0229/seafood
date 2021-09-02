<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>海龍王：後台管理系統</title>
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/dist/tocas.css">
        <script src="js/app.js"></script>
    </head>
    <body>
    <div id="login" class="display-flex">
        <div class="block-left"></div>
        <div class="block-right">
            <div class="width percent-70">
                <h1>海龍王</h1>
                <h5 class="margin-t-10px">後台管理系統</h5>
                <h6>帳號</h6>
                <div class="ts tiny input width percent-100">
                    <input type="text" class="width inherit" placeholder="請輸入帳號" v-model="account">
                </div>
                <h6>密碼</h6>
                <div class="ts tiny input width percent-100">
                    <input type="password" class="width inherit" placeholder="請輸入密碼" v-model="password">
                </div>
                <div class="margin-t-3 text-right">
                    <button class="ts positive mini button margin-r-2" @click="reset">重新輸入</button>
                    <button class="ts primary mini button" @click="login">登入</button>
                </div>
            </div>
        </div>
    </div>
    </body>

    <script>
        createApp({
            data() {
                return {
                    account: '',
                    password: '',
                }
            },
            delimiters: ["${", "}"],
            mounted() {

            },
            methods: {
                reset() {
                    this.account = '';
                    this.password = '';
                },
                login(){
                    let obj = {
                       account: this.account,
                       password: this.password,
                    };

                    axios.post('/login', obj).then(res => {
                        console.log(res);
                    }).catch(error => {

                    });
                }
            },
        }).mount('#login');

    </script>

</html>
