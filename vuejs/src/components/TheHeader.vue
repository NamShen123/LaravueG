<template>
    <div class="containter-fluid">
        <div class="row text-white" style="background-color: #0c713d; padding: 1rem;">
            <div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
                <span @click="showDrawer()">
                    <font-awesome-icon :icon="['fas', 'align-justify']" />
                </span>
            </div>

            <div class="col-10 col-sm-9 d-flex align-items-center justify-content-center justify-content-sm-start">
                <img src="../assets/riot-games.png" alt="Logo" height="32" width="34" class="ms-3 me-3">
                <span class="d-none d-sm-flex">QUẢN TRỊ</span>
            </div>

            <div class="col-sm-3 d-none d-sm-flex align-items-center justify-content-sm-end">
                <a-button @click="logout()" type="primary" danger>
                    <font-awesome-icon class="exitIcon" :icon="['fas', 'sign-out-alt']" />
                </a-button>
            </div>

            <div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
                <span @click="showDrawerUser()">
                    <font-awesome-icon :icon="['fas', 'user']" />
                </span>
            </div>
        </div>
    </div>

    <a-drawer v-model:open="open" title="DANH MỤC" placement="left">
        <TheMenu />
    </a-drawer>

    <a-drawer v-model:open="open_user" title="ADMIN" placement="right">
        <a-button style="width: 100%;" @click="logout()" type="primary" danger>
            <font-awesome-icon class="exitIcon" :icon="['fas', 'sign-out-alt']" />
        </a-button>
    </a-drawer>
</template>

<script setup>
import { api } from '../helper/api';
import TheMenu from './TheMenu.vue';
import { ref } from 'vue';
import { message } from 'ant-design-vue';
import { useRouter } from 'vue-router';

const open = ref(false);
const open_user = ref(false);
const router = useRouter();

const showDrawer = () => {
    open.value = true;
};

const showDrawerUser = () => {
    open_user.value = true;
};

api.attachToken();
api.setHeaderCommon('Accept', 'application/json');
const logout = async () => {

    try {
        const response = await axios.post('http://127.0.0.1:8000/api/logout');
        api.clearToken();
        message.success("Kết thúc phiên làm việc");
        router.push({ name: 'login' });
    } catch (error) {
        if (error.status === 401) {
            message.warning("Phiên làm việc đã hết hạn từ trước");
            router.push({ name: 'login' });
        } else {
            console.error(error);
        }
    }

}

const success = () => {
    message.success('This is a success message');
};

const warning = () => {
    message.warning('This is a warning message');
};

</script>

<style>
.exitIcon {
    transform: rotateZ(180deg);
}
</style>