export const pagination = {
    template: `
        <div class="col-12 clearfix">
            <!-- v-show -->
            <ul class="pagination float-right" v-show="pages > 1">
                <li class="page-item" :class="{'disabled': page === 1}">
                    <a class="page-link" href="#" @click.prevent="selectPage(1)"><<</a>
                </li>
                <li class="page-item" :class="{'disabled': page === 1}">
                    <a class="page-link" href="#" @click.prevent="selectPage(page - 1)"><</a>
                </li>

                <!-- v-for -->
                <li class="page-item" v-for="p in page_array">
                    <a class="page-link" :class="{'bg-blue': p === page}" href="#" @click.prevent="selectPage(p)">{{p}}</a>
                </li>

                <li class="page-item" :class="{'disabled': page === pages}">
                    <a class="page-link" href="#" @click.prevent="selectPage(page + 1)">></a>
                </li>
                <li class="page-item" :class="{'disabled': page === pages}">
                    <a class="page-link" href="#" @click.prevent="selectPage(pages)">>></a>
                </li>
            </ul>
        </div>
    `,
    props: {
        all_count: Number,
        page_count: Number,
    },
    watch: {
        'all_count'(new_data, old_data) {
            this.page = 1;
            this.pages = Math.ceil(new_data / this.page_count);
            this.page_array = [];
            let start = this.page - 2;
            let end = this.page + 2;
            for (let p = start; p <= end; p++) {
                if (p >= 1 && p <= this.pages) {
                    this.page_array.push(p);
                }
            }
        },
        'page'(new_data, old_data) {
            this.page_array = [];
            let start = this.page - 2;
            let end = this.page + 2;
            for (let p = start; p <= end; p++) {
                if (p >= 1 && p <= this.pages) {
                    this.page_array.push(p);
                }
            }
        },
    },
    data() {
        return {
            page: 1,
            pages: 0,
            page_array: [],
        }
    },
    methods: {
        selectPage(page) {
            loading.show = true;
            if (page >= 1 && page <= this.pages) {
                this.page = page;
                this.$emit('get-data', page);
                this.$emit('set-page', page);
            }
        },
    },
}
