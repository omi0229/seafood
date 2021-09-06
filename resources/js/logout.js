createApp({
    methods: {
        confirm() {
            Swal.fire({
                title: '確定登出？',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                allowOutsideClick: false,
                confirmButtonClass: 'btn btn-sm btn-success px-3 ml-1',
                cancelButtonClass: 'btn btn-sm btn-danger px-3 mr-1',
                buttonsStyling: false,
                reverseButtons: true,
                padding: 30,
                width: 300,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.logout();
                }
            })
        },
        logout() {
            window.loading.show = true;
            axios.post('/logout').then(async res => {
                if (res.data.status) {
                    location.href = '/login';
                }
            }).catch(error => {

            });
        }
    },
}).mount('#logout');
