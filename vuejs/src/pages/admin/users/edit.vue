<template>
    <form @submit.prevent="userEdit">
        <a-card title="Cập nhật tài khoản" style="width: 100%;">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-3">
                            <a-avatar :size="200" shape="square">
                                <template #icon>
                                    <img src="../../../assets/defaulAvatar.jpg" alt="avatar">
                                </template>
                            </a-avatar>
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <a-button type="primary">
                                <font-awesome-icon :icon="['fas', 'plus']" class="me-2" />
                                <span>Chọn ảnh</span>
                            </a-button>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-sm-8">
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <span class="text-danger me-1">*</span>
                            <label :class="{ 'text-danger': errors.status_id }">
                                Tình trạng:
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-select show-search placeholder="Tình trạng" style="width: 100%" :options="user_status"
                                :filter-option="filterOption" allow-clear v-model:value="status_id"
                                :status="errors.status_id ? 'error' : null">
                            </a-select>
                            <div class="w-100"></div>
                            <small v-if="errors.status_id" class="text-danger">{{ errors.status_id[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <span class="text-danger me-1">*</span>
                            <label for="" :class="{ 'text-danger': errors.username }">
                                Tên đăng nhập:
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Tên đăng nhập" allow-clear v-model:value="username"
                                :status="errors.username ? 'error' : null" disabled />
                            <div class="w-100"></div>
                            <small v-if="errors.username" class="text-danger">{{ errors.username[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <span class="text-danger me-1">*</span>
                            <label for="" :class="{ 'text-danger': errors.name }">
                                Họ và tên:
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Họ và tên" allow-clear v-model:value="name"
                                :status="errors.name ? 'error' : null" />
                            <div class="w-100"></div>
                            <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <span class="text-danger me-1">*</span>
                            <label for="" :class="{ 'text-danger': errors.email }">
                                Email:
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Email" allow-clear v-model:value="email"
                                :status="errors.email ? 'error' : null" />
                            <div class="w-100"></div>
                            <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <span class="text-danger me-1">*</span>
                            <label :class="{ 'text-danger': errors.departments_id }">
                                Vai trò:
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-select show-search placeholder="Vai trò" style="width: 100%" :options="departments"
                                :filter-option="filterOption" allow-clear v-model:value="departments_id"
                                :status="errors.departments_id ? 'error' : null">
                            </a-select>
                            <div class="w-100"></div>
                            <small v-if="errors.departments_id" class="text-danger">{{ errors.departments_id[0]
                                }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <a-checkbox v-model:checked="isChangePassword">Đổi mật khẩu</a-checkbox>
                        </div>
                    </div>

                    <div class="row mb-3" v-if="isChangePassword">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <span class="text-danger me-1">*</span>
                            <label :class="{ 'text-danger': errors.password }">
                                Mật khẩu:
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password placeholder="Mật khẩu" allow-clear v-model:value="password"
                                :status="errors.password ? 'error' : null" />
                            <div class="w-100"></div>
                            <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3" v-if="isChangePassword">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <span class="text-danger me-1">*</span>
                            <label for="" :class="{ 'text-danger': errors.password_confirmation }">
                                Xác nhận mật khẩu:
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password placeholder="Xác nhận mật khẩu" allow-clear
                                v-model:value="password_confirmation"
                                :status="errors.password_confirmation ? 'error' : null" />
                            <div class="w-100"></div>
                            <small v-if="errors.password_confirmation" class="text-danger">{{
                                errors.password_confirmation[0] }}</small>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-end">
                            <router-link :to="{ name: 'admin-users' }">
                                <a-button class="me-2">
                                    <span>Hủy</span>
                                </a-button>
                            </router-link>

                            <a-button type="primary" html-type="submit">
                                <span>Lưu</span>
                            </a-button>
                        </div>
                    </div>
                </div>
            </div>
        </a-card>
    </form>

</template>

<script>
import { defineComponent, ref, reactive, toRefs } from 'vue';
import { useMenu } from '../../../stores/useMenu';
import { message } from 'ant-design-vue';
import { useRoute } from 'vue-router';
import { api } from '../../../helper/api';
import { useRouter } from 'vue-router';


export default defineComponent({

    setup() {

        const router = useRouter();

        api.attachToken();
        api.setHeaderCommon('Accept', 'application/json');

        useMenu().onSelectedKeys(['1']);

        const route =  useRoute ();

        const user_status = ref([]);
        const departments = ref([]);
        const isChangePassword = ref(false);

        const users = reactive({
            username: "",
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            departments_id: [],
            status_id: [],
            isChangePassword: isChangePassword,
        });

        const errors = ref({});

        const getUsersSelectEdit = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/users/create');

                const status_response = response.data.user_status;
                const department_response = response.data.departments;


                for (let x in status_response) {

                    user_status.value.push({
                        "value": status_response[x].id,
                        "label": status_response[x].name,
                    });
                }

                for (let x in response.data.departments) {
                    departments.value.push({
                        "value": department_response[x].id,
                        "label": department_response[x].name,
                    });
                }

            } catch (error) {
                console.error(response);
                
            }
        }

        getUsersSelectEdit();
        
        const fillUserEdit = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/users/${route.params.id}`);
                users.username = response.data.username;
                users.name = response.data.name;
                users.email = response.data.email;
                users.departments_id = response.data.departments_id;
                users.status_id = response.data.status_id;
            } catch (error) {
                if (error.status === 401) {
                    message.warning('Phiên đăng nhập hết hạn');
                    router.push({ name: 'login' });
                } else {
                    console.error(error);
                }
            }
        }

        fillUserEdit();

        const userEdit = async () => {
            try {
                const response = await axios.post(`http://127.0.0.1:8000/api/users/${route.params.id}`, users);
                message.success('Cập nhật tài khoản thành công');
            } catch (error) {
                if (error.status === 401) {
                    message.warning('Phiên đăng nhập hết hạn');
                    router.push({ name: 'login' });
                } else {
                    console.error(error);
                    errors.value = error.response.data;
                }
            }
        }


        const filterOption = (input, option) => {
            return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
        };

        const success = () => {
            message.success("Cập nhật tài khoản thành công");
        };
        const warning = () => {
            message.warning('This is a warning message');
        };

        return {
            user_status,
            departments,
            ...toRefs(users),
            errors,
            isChangePassword,


            filterOption,
            success,
            userEdit,
            warning,
        }
    }
})
</script>