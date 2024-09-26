<template>
    <a-card title="Tài khoản" style="width: 100%">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <router-link :to="{ name: 'admin-users-create' }">
                    <a-button type="primary">
                        <font-awesome-icon :icon="['fas', 'plus']" />
                    </a-button>
                </router-link>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a-table :dataSource="users" :columns="columns" :scroll="{ x: 600, y: 500 }">
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'index'">
                            <span>{{ index + 1 }}</span>
                        </template>

                        <template v-if="column.key === 'status'">
                            <span v-if="record.status === 'ACTIVE'" class="text-primary">{{ record.status }}</span>
                            <span v-else-if="record.status === 'DEACTIVE'" class="text-danger">{{ record.status
                                }}</span>
                        </template>

                        <template v-if="column.key === 'department'">
                            <a-tag color="#0c713d">{{ record.department }}</a-tag>
                        </template>

                        <template v-if="column.key === 'avatar'">
                            <img src="../../../assets/defaulAvatar.jpg" alt="avatar" height="32" width="34"
                                class="ms-3 me-3">
                        </template>

                        <template v-if="column.key === 'action'">
                            <router-link :to="{ name: 'admin-users-edit', params: { id: record.id } }">
                                <a-button class="me-sm-2 mb-2">
                                    <font-awesome-icon :icon="['fas', 'edit']" />
                                </a-button>
                            </router-link>


                            <a-button @click="showPromiseConfirm(record.id)">
                                <font-awesome-icon :icon="['fas', 'trash']" />
                            </a-button>

                        </template>

                    </template>
                </a-table>
            </div>
        </div>
    </a-card>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { useMenu } from '../../../stores/useMenu';
import { ExclamationCircleOutlined } from '@ant-design/icons-vue';
import { createVNode } from 'vue';
import { Modal } from 'ant-design-vue';
import { message } from 'ant-design-vue';
import axios from 'axios';
export default defineComponent({
    setup() {
        useMenu().onSelectedKeys(['1']);

        const columns = [
            {
                title: "#",
                key: "index",
            },
            {
                title: 'Avatar',
                dataIndex: 'avatar',
                key: 'avatar',
                responsive: ['sm']
            },
            {
                title: 'Tài khoản',
                dataIndex: 'username',
                key: 'username',
            },
            {
                title: 'Email',
                dataIndex: 'email',
                key: 'email',
            },
            {
                title: 'Vai trò',
                dataIndex: 'department',
                key: 'department',
            },
            {
                title: 'Trạng thái',
                dataIndex: 'status',
                key: 'status',
            },
            {
                title: 'Action',
                key: 'action',
                fixed: 'right',
            },
        ]

        const users = ref([]);

        const getUsers = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/users');
                users.value = response.data;
            } catch (error) {
                console.error(error);
            }
        };

        getUsers();

        const showPromiseConfirm = (userId) => {
            Modal.confirm({
                title: 'Bạn muốn xóa người dùng này?',
                icon: createVNode(ExclamationCircleOutlined),
                // content: 'When clicked the OK button, this dialog will be closed after 1 second',
                async onOk() {
                    try {
                        const response = await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`);
                        if (response.status == 200) {
                            getUsers();
                        }
                        return await new Promise((resolve, reject) => {
                            setTimeout(Math.random() > 0.5 ? resolve : reject, 1000);
                            message.success("Xóa thành công");
                        });
                    } catch (error) {
                        return console.error(error);
                    }
                },
                onCancel() { },
            });
        }

        const success = () => {
            message.success("success");
        };

        return {
            users,
            columns,

            showPromiseConfirm,
            success,
        }
    }
});

</script>