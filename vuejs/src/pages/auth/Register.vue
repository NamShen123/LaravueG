<template>
  <div class="container">
    <div class="d-flex justify-content-center">
      <a-card class="loginBox" hoverable>
        <template #cover>
          <div class="d-flex justify-content-center">
            <img class="mt-4" style="max-width: 200px; max-height: 200px;" alt="example"
              src="../../assets/riot-games.png" />
          </div>
        </template>
        <a-card-meta>
          <template #description>
            <a-form layout="inline" :model="formState" @finish="handleFinish">
              <div class="d-flex flex-column">

                <a-form-item class="mb-2">
                  <small v-if="clickedStatus.username">Tên đăng nhập</small>
                  <a-input @focus="showLabel('username')" @blur="hideLabel('username')"
                    v-model:value="formState.username" placeholder="Username"
                    :status="errors.username ? 'error' : null">
                    <template #prefix></template>
                  </a-input>
                  <small v-if="errors.username" class="text-danger">{{ errors.username[0] }}</small>
                </a-form-item>

                <a-form-item class="mb-2">
                  <small v-if="clickedStatus.password">Mật khẩu</small>
                  <a-input @focus="showLabel('password')" @blur="hideLabel('password')"
                    v-model:value="formState.password" type="password" placeholder="Password"
                    :status="errors.password ? 'error' : null">
                    <template #prefix></template>
                  </a-input>
                  <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                </a-form-item>

                <a-form-item class="mb-2">
                  <small v-if="clickedStatus.password_confirmation">Xác nhận mật khẩu</small>
                  <a-input @focus="showLabel('password_confirmation')" @blur="hideLabel('password_confirmation')"
                    v-model:value="formState.password_confirmation" type="password" placeholder="Password Confirm"
                    :status="errors.password_confirmation ? 'error' : null">
                    <template #prefix></template>
                  </a-input>
                  <small v-if="errors.password_confirmation" class="text-danger">{{ errors.password_confirmation[0]
                    }}</small>
                </a-form-item>

                <a-form-item class="mb-2">
                  <small v-if="clickedStatus.email">Email</small>
                  <a-input @focus="showLabel('email')" @blur="hideLabel('email')" v-model:value="formState.email"
                    placeholder="Email" :status="errors.email ? 'error' : null">
                    <template #prefix></template>
                  </a-input>
                  <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                </a-form-item>

                <a-form-item class="mb-2" style="width: 100%;">
                  <small v-if="clickedStatus.name">Tên</small>
                  <a-input @focus="showLabel('name')" @blur="hideLabel('name')" v-model:value="formState.name"
                    placeholder="Name" :status="errors.name ? 'error' : null">
                    <template #prefix></template>
                  </a-input>
                  <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                </a-form-item>

                <a-form-item>
                  <div class="d-flex justify-content-between">
                    <div style="width: 62%;">
                      <a-button :block="true" type="primary" html-type="submit" style="width: 100%;"
                        :disabled="formState.username === '' || formState.password === '' || formState.password_confirmation === '' || formState.email === '' || formState.name === ''">
                        Đăng ký
                      </a-button>
                    </div>
                    <div style="width: 36%;">
                      <router-link :to="{ name: 'login' }">
                        <a-button :block="true" html-type="submit" style="width: 100%;">
                          Đăng Nhập
                        </a-button>
                      </router-link>
                    </div>

                  </div>
                </a-form-item>

              </div>
            </a-form>
          </template>
        </a-card-meta>
      </a-card>

    </div>
  </div>


</template>
<script setup>
import { reactive, ref } from 'vue';
import { useAuthStore } from '../../stores/useAuth';
import { useRouter } from 'vue-router';
import { api } from '../../helper/api';
import { message } from 'ant-design-vue';

const formState = reactive({
  username: '',
  password: '',
  password_confirmation: '',
  email: '',
  name: '',
});

const clickedStatus = reactive({
  // username: false,
  // password: false,
  // password_confirmation: false,
  // email: false,
  // name: false,
  username: true,
  password: true,
  password_confirmation: true,
  email: true,
  name: true,
});


const authStore = useAuthStore();
const router = useRouter();
const errors = ref({});

const showLabel = (name) => {
  clickedStatus[name] = true;
}

const hideLabel = (name) => {
  // clickedStatus[name] = false;
  clickedStatus[name] = true;
}

api.clearToken();
api.setHeaderCommon('Accept', 'application/json');

const handleFinish = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/register', formState);
    message.success("Đăng ký thành công!");
    router.push({ name: 'login' });

  } catch (error) {
    if (error.status === 400) {
      errors.value = error.response.data;
    } else {
      console.error(error);
    }
  }
};

const success = () => {
  message.success('This is a success message');
};
</script>

<style scoped>
.loginBox {
  margin-top: 100px;
}
</style>