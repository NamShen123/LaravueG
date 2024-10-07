<template>
    <a-card style="width: 100%" :tab-list="tabListNoTitle" :active-tab-key="noTitleKey"
        @tabChange="key => onTabChange(key)">

        <!-- Library -->
        <div v-if="noTitleKey === 'library'">
            <div class="row">
                <div v-for="book in booksData.item" class="col-6 col-sm-3 mb-4">
                    <a-card hoverable style="width: 100%; height: 100%;">
                        <template #cover>
                            <img alt="book" src="../../../assets/bookCover.avif" />
                        </template>
                        <a-card-meta :title="book.name">
                            <template #description>
                                <div class="ellipsis-multiline">
                                    {{ book.description }}
                                </div>

                                <div class="text-end mb-2 ellipsis-twoline">
                                    <a-typography-text :code="true" class="font-italic">{{ book.author
                                        }}</a-typography-text>
                                </div>

                                <div class="text-end mb-2">
                                    <a-typography-text>{{ money.format(book.price) }}</a-typography-text>
                                </div>

                                <div>
                                    <div v-if="userBooks.hasBookId(book.id)">
                                        <a-button class="borringButton"
                                            type="primary" style="margin-top: 1em; width: 100%;">
                                            <HistoryOutlined/>
                                        </a-button>
                                    </div>


                                    <div v-else-if="callSlip.hasBookId(book.id)">
                                        <a-button @click="callSlip.remove(book);" class="cancelButton"
                                            type="primary" style="margin-top: 1em; width: 100%;">
                                            Hủy
                                        </a-button>
                                    </div>

                                    <div v-else-if="book.quantity > 0">
                                        <a-button @click="callSlip.storage(book)" class="addButton" type="primary"
                                            style="margin-top: 1em; width: 100%;">
                                            Thêm
                                        </a-button>
                                    </div>

                                    <div v-else>
                                        <a-button :data-book="JSON.stringify(book)" disabled type="primary"
                                            style="margin-top: 1em; width: 100%;">
                                            Tạm hết
                                        </a-button>
                                    </div>
                                </div>


                            </template>
                        </a-card-meta>
                    </a-card>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <a-pagination @change="goPage" :showSizeChanger="false" :defaultPageSize="booksData.pageSize"
                    v-model:current="booksData.current" :total="booksData.total" show-less-items />
            </div>
        </div>

        <!-- Books -->
        <div v-else-if="noTitleKey === 'myBooks'">

            <div class="row">
                <div v-for="book in userBooks.borring_books.current_items" class="col-6 col-sm-3 mb-4">
                    <a-badge-ribbon text="đang mượn" color="gold">
                        <a-card hoverable >
                            <template #cover>
                                <img alt="book" src="../../../assets/bookCover.avif" />
                            </template>
                            <a-card-meta :title="book.name">
                                <template #description>
                                    <div class="ellipsis-multiline">
                                        {{ book.description }}
                                    </div>

                                    <div class="text-end mb-2 ellipsis-twoline">
                                        <a-typography-text :code="true" class="font-italic">{{ book.author
                                            }}</a-typography-text>
                                    </div>

                                    <div class="text-end mb-2">
                                        <a-typography-text>{{ money.format(book.price) }}</a-typography-text>
                                    </div>
                                </template>
                            </a-card-meta>
                        </a-card>
                    </a-badge-ribbon>
                </div>
            </div>
        </div>
        <div v-else>Ngoại lệ phát sinh</div>

    </a-card>

</template>

<script setup>
import { useMenu } from '../../../stores/useMenu';
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router'
import { message } from 'ant-design-vue';
import { api } from '../../../helper/api.js'
import { money } from '../../../helper/money.js';
import {
    PlusOutlined,
    HistoryOutlined,
} from '@ant-design/icons-vue';
import { useCallSlip } from '../../../stores/useCallSlip.js';
import { useUserBooks } from '../../../stores/useUserBooks.js';

const router = useRouter();

useMenu().onSelectedKeys(['1']);

const tabListNoTitle = [
    {
        key: 'library',
        tab: 'Thư viện',
    },
    {
        key: 'myBooks',
        tab: 'Sách của tôi',
    },
];
const noTitleKey = ref('library');
const onTabChange = (value) => {
    noTitleKey.value = value;

    if (value === 'myBooks') {
        getUserBooks();
    }
};

const booksData = reactive({
    current: 1,
    pageSize: 12,
    total: 50,
    item: [],
    innit: true,
})

const callSlip = useCallSlip();


api.attachToken();
api.setHeaderCommon();

const getBooks = async () => {
    try {
        let searchParam = `?page=${booksData.current}`;
        if (booksData.innit) {
            searchParam = '';
            booksData.innit = false;
        }
        const response = await axios.get(`http://localhost:8000/api/books${searchParam}`);
        booksData.current = response.data.current_page;
        booksData.pageSize = response.data.per_page;
        booksData.total = response.data.total;
        booksData.item = response.data.data
    } catch (error) {
        if (error.status === 401) {
            message.warning("Phiên đăng nhập hết hạn");
            router.push({ name: 'login' });
        } else {
            console.error(error);
        }
    }
}

if (booksData.innit) {
    getBooks();
}

const goPage = (page) => {
    booksData.current = page;
    getBooks();
}

const userBooks = useUserBooks();


api.attachToken();
api.setHeaderCommon();
const getUserBooks = async () => {
    try {
        const response = await axios.get("http://localhost:8000/api/books/user");
        userBooks.empty();
        userBooks.massStorage(response.data.borring_books);
    } catch (error) {
        if (error.status === 401) {
            message.warning("Hết hạn phiên đăng nhập");
            router.push({ name: 'login' });
        } else {
            console.error(error);
        }
    }
}

if (!userBooks.isFetch) {
    getUserBooks();
    userBooks.isFetch = true;
}


</script>

<style scoped>
.ellipsis-multiline {
    min-height: 5em;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
}

.ellipsis-twoline {
    min-height: 5em;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
}

.addButton {
    background-color: green;
}

.addButton:hover {
    background-color: #AAFF00;
    color: black;
}

.cancelButton {
    background-color: #FFCCCB;
    color: black;
}

.cancelButton:hover {
    background-color: #FFCCCB;
    color: black;
}

.borringButton {
    background-color: rgb(250, 173, 20);
    color: black;
}

.borringButton:hover {
    background-color: rgb(250, 173, 20);
    color: black;
}
</style>