<template>
    <a-menu v-model:selectedKeys="selectedKeys" mode="inline" :items="items" @click="handleClick">
    </a-menu>
</template>

<script setup>
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useMenu } from "../stores/useMenu.js";
import { storeToRefs } from 'pinia'

import {
    UserOutlined,
    AuditOutlined,
    BookOutlined,
    SnippetsOutlined,
} from '@ant-design/icons-vue';
import { h } from 'vue';
import { useCallSlip } from '../stores/useCallSlip.js';

const router = useRouter();

const store = useMenu();

const { selectedKeys } = storeToRefs(store);


const items = reactive([
    {
        key: '1',
        label: 'Sách',
        title: 'BOOK',
        icon: h(BookOutlined),
        routeName: 'user-books'
    },
    {
        key: '2',
        label: 'Thẻ mượn',
        title: 'CALL_SLIP',
        icon: h(SnippetsOutlined),
        routeName: 'user-call-slips',
    },
    {
        key: '3',
        label: 'Tài khoản',
        title: 'USERS',
        icon: h(UserOutlined),
        routeName: 'user-account'
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
