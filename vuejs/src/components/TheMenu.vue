<template>
    <a-menu
        v-model:selectedKeys="selectedKeys"
        mode="inline" 
        :items="items"
        @click="handleClick">
    </a-menu>
</template>

<script setup>
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useMenu } from "../stores/useMenu.js";
import { storeToRefs } from 'pinia'

import {
  UserOutlined,
  SettingOutlined,
  AuditOutlined,
} from '@ant-design/icons-vue';
import { h } from 'vue';

const router = useRouter();

const store = useMenu();

const { selectedKeys } = storeToRefs(store);


const items = reactive([
    {
        key: '1',
        label: 'Tài khoản',
        title: 'USERS',
        icon: h(UserOutlined),
        routeName: 'admin-users'
    },
    {
        key: '2',
        label: 'Vai trò',
        title: 'ROLES',
        icon: h(AuditOutlined),
        routeName: 'admin-roles'
    },
    {
        key: '3',
        label: 'Thiết lập',
        title: 'SETTINGS',
        icon: h(SettingOutlined),
        routeName: 'admin-settings'
    },
]);


function handleClick(domItem) {
    router.push(
        {
            name: domItem.item.routeName
        }
    )
}

</script>

