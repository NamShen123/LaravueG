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

                <a-button @click="showModal" :block="responsiveHelper.isMobileWidth()" class="m-2"
                    :disabled="callSlip.isEmpty()" type="primary">
                    <ExportOutlined /> Tạo phiếu mượn
                </a-button>

                <a-modal v-model:open="open" title="Tạo phiếu mượn" :confirm-loading="confirmLoading" @ok="handleOk">
                </a-modal>
            </div>
        </div>

        <!-- list call slip -->
        <div v-else-if="noTitleKey === 'callSlips'">

            <div v-for="userCallSlip in callSlips.current_items">
                <a-badge-ribbon :text="userCallSlip.status">
                    <a-card :title="`Phiếu mượn #${userCallSlip.id}`" size="small">
                        <div class="mb-1" v-for="book in userCallSlip.books">
                            <a-typography-text strong>{{ `${book.name} ` }}</a-typography-text>
                            <a-typography-text code>{{ book.author }}</a-typography-text>
                        </div>
                        <br></br>
                        <div class="mb-1">
                            Đã thanh toán: <a-typography-text keyboard>{{ userCallSlip.deposit }}</a-typography-text>
                        </div>
                        <div class="mb-1">
                            Người duyệt: 
                            <a-tag v-if="!userCallSlip.staff" color="processing">
                                <template #icon>
                                    <sync-outlined :spin="true" />
                                </template>
                                đang duyệt
                            </a-tag>
                        </div>
                    </a-card>
                </a-badge-ribbon>
            </div>




        </div>
        <div v-else>Ngoại lệ phát sinh</div>

    </a-card>
</template>

<script setup>
import { useMenu } from '../../../stores/useMenu';
import { useCallSlip } from '../../../stores/useCallSlip';
import { reactive, ref } from 'vue';
import { money } from '../../../helper/money';
import {
    PlusOutlined,
    ClearOutlined,
    ExportOutlined,
    SyncOutlined,
} from '@ant-design/icons-vue';
import { responsiveHelper } from '../../../helper/responsiveHelper';
import { useRouter } from 'vue-router';
import { message } from 'ant-design-vue';
import { useUserCallSlips } from '../../../stores/useUserCallSlips';

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

    if (value === 'callSlips') {
        getuserCallSlip();
    }
};

const callSlip = useCallSlip();

const deposit = ref(0);
const open = ref(false);
const confirmLoading = ref(false);
const showModal = () => {
    open.value = true;
};

const router = useRouter();

const calcDeposit = () => {
    let amount = 0;
    callSlip.current_items.forEach(
        (item) => {
            amount += parseInt(item.price);
        }
    )
    return amount;
}

const handleOk = async () => {
    confirmLoading.value = true;

    try {
        deposit.value = calcDeposit();


        const response = await axios.post('http://localhost:8000/api/callSlips', {
            deposit: deposit.value,
            book_ids: callSlip.current_ids,
        });

        // TODO: đang bị lưu sách đã mượn

        message.success("Tạo phiếu mượn thành công");
        callSlip.empty();

    } catch (error) {
        if (error.status === 401) {
            message.warning("Hết phiên đăng nhập");
            router.push({ name: 'login' });
        } else if (error.status === 400) {
            message.warning(error.response.data.message);
        } else if (error.status === 409) {
            message.warning(error.response.data.message);
        } else {
            console.error(error);
        }

    }
    open.value = false;
    confirmLoading.value = false;
};

const callSlips = useUserCallSlips();

const getuserCallSlip = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/callSlips/user');
        callSlips.empty();
        callSlips.massStorage(response.data);
    } catch (error) {
        if (error.status === 401) {
            message.warning("Hết phiên đăng nhập");
            router.push({ name: 'login' });
        } else {
            console.error(error);
        }
    }
}





</script>