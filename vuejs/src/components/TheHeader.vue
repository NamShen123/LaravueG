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
                <span>Admin</span>
            </div>

            <div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
                <span @click="showDrawerUser()">
                    <font-awesome-icon :icon="['fas', 'user']" />
                </span>
            </div>
        </div>
    </div>

    <a-drawer v-model:open="open" title="DANH MỤC" placement="left">
        <TheMenu/>
    </a-drawer>

    <a-drawer v-model:open="open_user" title="ADMIN" placement="right">
        <p>Some contents...</p>
        <p>Some contents...</p>
        <p>Some contents...</p>
    </a-drawer>
</template>

<script setup>
import TheMenu from './TheMenu.vue';
import { ref } from 'vue';
const open = ref(false);
const open_user = ref(false);

const showDrawer = () => {
    open.value = true;
};

const showDrawerUser = () => {
    open_user.value = true;
};
</script>