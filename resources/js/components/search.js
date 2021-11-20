export const search = {
    template: `
        <link rel="stylesheet" href="css/components/search.css">
        <div class="input-group search-width">
            <input type="text" class="form-control form-control-sm" :placeholder="'請輸入' + name + '名稱'" :value="search_text" @input="searchText($event.target.value)" @keyup.enter="getData">
            <div class="input-group-append">
                <button type="button" class="btn btn-sm btn-default" @click="getData">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    `,
    props: {
        name: String,
        search_text: String,
    },
    setup(props, {emit}) {
        const searchText = value => {
            emit('update:search_text', value);
        }

        const getData = async () => {
            loading.show = true;
            await emit('get-data', 1, 1);
            await emit('get-count', 1);
        }

        return {
            searchText,
            getData
        }
    },
}
