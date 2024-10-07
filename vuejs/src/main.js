import { createApp } from 'vue'
import { 
    Badge,
    Typography,
    Pagination,
    Anchor,
    Form,
    Modal,
    Checkbox,
    Input,
    Select,
    Avatar,
    Tag,
    Table,
    Card,
    Menu,
    List,
    Drawer,
    Button,
    message,
} from 'ant-design-vue';
import router from './router/index.js';
import App from './App.vue';
import { createPinia } from 'pinia';
import axios from 'axios';

axios.defaults.headers.common['Accept'] = 'application/json';
window.axios = axios;


import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
library.add(fas, fab, far);

import 'ant-design-vue/dist/reset.css';
import 'bootstrap/dist/css/bootstrap-grid.min.css';
import 'bootstrap/dist/css/bootstrap-utilities.min.css';

const pinia = createPinia();
const app  = createApp(App);
app.component('font-awesome-icon', FontAwesomeIcon);
app.use(router);
app.use(Badge);
app.use(Button);
app.use(Typography);
app.use(Pagination);
app.use(Anchor);
app.use(Modal);
app.use(Form);
app.use(Checkbox);
app.use(Select);
app.use(Input);
app.use(Avatar);
app.use(Tag);
app.use(Table);
app.use(Card);
app.use(Drawer);
app.use(Menu);
app.use(List);
app.use(pinia);
app.mount('#app');

app.config.globalProperties.$message = message;
