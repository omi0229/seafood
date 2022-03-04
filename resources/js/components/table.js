import moment from 'moment';
import { swal2Confirm } from '../bootstrap';
import { ref, watch, computed, getCurrentInstance } from 'vue'

export const table = {
    template: `
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title text-nowrap">{{ name }}</h3>
                <div class="text-right w-100">
                    <template v-if="!is_sort_open">
                        <button class="btn btn-sm btn-secondary" @click="is_sort_open = true">修改排序</button>
                    </template>
                    <template v-else>
                        <button class="btn btn-sm btn-danger mr-1" @click="is_sort_open = false">取消</button>
                        <button class="btn btn-sm btn-primary" @click="saveSort">儲存排序</button>
                    </template>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <!-- v-if -->
                    <tr v-if="list.length > 0">
                        <th class="align-middle">
                            <input type="checkbox" class="checkbox-size" v-model="checkAll">
                        </th>
                        <th>目錄名稱</th>
                        <th class="text-center">排序</th>
                        <th class="text-center">建立日期</th>
                        <th class="text-center">上次異動日期</th>
                        <th class="text-center">功能</th>
                    </tr>
                    <tr v-else>
                        <th class="text-center" colspan="5"><span class="text-danger">無目錄資料</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- v-for -->
                    <tr v-for="item in list">
                        <td class="align-middle">
                            <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                        </td>
                        <td>{{ item.name }}</td>
                        <td class="text-center width percent-10">
                            <template v-if="is_sort_open"><input type="text" class="form-control form-control-sm text-center" maxlength="4" v-model.number="item.location" /></template>
                            <template v-else>{{ locationFormat(item.location) }}</template>
                        </td>
                        <td class="text-center">{{ dateFormat(item.created_at) }}</td>
                        <td class="text-center">{{ dateFormat(item.updated_at) }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-info px-2" data-toggle="modal" data-target="#set-info" @click="modify(item.id)">
                                <i class="fa fa-edit mr-1"></i> 編輯
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `,
    props: {
        'type': String,
        'name': String,
        'list': Array,
    },
    setup(props, {emit}) {
        const check = ref([]);
        watch(check, (newValue, oldValue) => { setCheck(newValue) });

        const checkAll = ref(false);
        watch(checkAll, (newValue, oldValue) => { check.value = newValue ? _.map(props.list, 'id') : [] });

        const is_sort_open = ref(false);

        let dateFormat = computed(() => {
            return datetime => {
                return moment(datetime).format('Y-MM-DD HH:mm')
            }
        });

        const modify = id => { emit('modify', id) };

        const setCheck = value => { emit('update:check', value) };

        const instance = getCurrentInstance();

        const saveSort = () => {
            swal2Confirm('確定修改排序？').then(confirm => {
                if (confirm) {
                    let type = props.type
                    let list = _.map(instance.parent.data.list, v => { return { id: v.id, location: v.location} })
                    axiosPostMethod('/sort/save', { type, list }).then(res => {
                        is_sort_open.value = false;
                        res.data ? Toast.fire({icon: 'success', title: '修改成功'}) : Toast.fire({icon: 'error', title: '修改失敗'});
                    })
                }
            });
        }

        let locationFormat = computed(() => {
            return location => {
                return location ? location : 0;
            }
        });

        return {
            check,
            checkAll,
            is_sort_open,
            dateFormat,
            locationFormat,
            modify,
            setCheck,
            saveSort
        }
    },
}
