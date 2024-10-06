<template>
    <a-card style="width: 100%" :tab-list="tabListNoTitle" :active-tab-key="noTitleKey"
        @tabChange="key => onTabChange(key)">

        <!-- call slip -->
        <div v-if="noTitleKey === 'curentCallSlip'">
            <div class="mb-2" v-for="book in callSlip.current_items">
                <a-card size="small" :title="book.name" style="width: 100%">
                    <template #extra><a @click="callSlip.removeById(book.id)">Hủy</a></template>
                    <div class="d-sm-flex justify-content-sm-between">
                        <div>Tác giả: {{ book.author }}</div>
                        <div>{{ money.format(book.price) }}</div>
                    </div>
                </a-card>
            </div>
            <div class="d-sm-flex justify-content-sm-end">
                <router-link :to="{ name: 'user-books' }">
                    <a-button class="m-2">
                        <PlusOutlined /> Thêm sách
                    </a-button>
                </router-link>

                <a-button @click="callSlip.empty()" class="m-2">
                    <ClearOutlined /> Bỏ tất cả
                </a-button>

                <a-button :block="responsiveHelper.isMobileWidth()" class="m-2" :disabled="callSlip.isEmpty()"
                    type="primary">
                    <ExportOutlined /> Tạo phiếu mượn
                </a-button>
            </div>
        </div>

        <!-- list call slip -->
        <div v-else-if="noTitleKey === 'callSlips'">
            Books content
        </div>
        <div v-else>Ngoại lệ phát sinh</div>

    </a-card>
</template>

<script setup>
import { useMenu } from '../../../stores/useMenu';
import { useCallSlip } from '../../../stores/useCallSlip';
import { ref } from 'vue';
import { money } from '../../../helper/money';
import {
    PlusOutlined,
    ClearOutlined,
    ExportOutlined,
} from '@ant-design/icons-vue';
import { responsiveHelper } from '../../../helper/responsiveHelper';

useMenu().onSelectedKeys(['2']);

const tabListNoTitle = [
    {
        key: 'curentCallSlip',
        tab: 'Tạo thẻ',
    },
    {
        key: 'callSlips',
        tab: 'Thẻ mượn',
    },
];

const noTitleKey = ref('curentCallSlip');
const onTabChange = (value) => {
    noTitleKey.value = value;
};

const callSlip = useCallSlip();







</script>