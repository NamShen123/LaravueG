<template>
  <div class="container">
    <div class="d-flex justify-content-center">
      <a-card class="loginBox" hoverable>
        <template #cover>
          <div class="d-flex justify-content-center">
            <img style="max-width: 200px; max-height: 200px;" alt="example" src="../../assets/riot-games.png" />
          </div>
        </template>
        <a-card-meta>
          <template #description>
            <a-form layout="inline" :model="formState" @finish="handleFinish">
              <div class="d-flex flex-column">
                <a-form-item class="mb-1">
                  <small class="mt-1">Tên đăng nhập</small>
                  <a-input v-model:value="formState.username" placeholder="Username">
                    <template #prefix></template>
                  </a-input>
                </a-form-item>
                <a-form-item class="mb-1">
                  <small class="mt-1">Mật khẩu</small>
                  <a-input v-model:value="formState.password" type="password" placeholder="Password">
                    <template #prefix></template>
                  </a-input>
                </a-form-item>

                <a-form-item v-if="isLoginError" class="mt-1 mb-1 text-danger">
                  <span>Thông tin đăng nhập không chính xác</span>
                </a-form-item>



                <a-form-item class="mt-1">
                  <div class="d-flex justify-content-between">
                    <div style="width: 62%;">
                      <a-button :block="true" type="primary" html-type="submit" style="width: 100%;"
                        :disabled="formState.username === '' || formState.password === ''">
                        Đăng nhập
                      </a-button>
                    </div>
                    <div style="width: 36%;">
                      <router-link :to="{ name: 'register' }">
                        <a-button :block="true" html-type="submit" style="width: 100%; padding-left:0.5em; padding-right: 0.5em;">
                          Đăng ký
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
});

const isLoginError = ref(false);

const authStore = useAuthStore();
const router = useRouter();


const handleFinish = async () => {
  try {
    api.setHeaderCommon('Accept', '*/*');
    await axios.get('/sanctum/csrf-cookie');
    api.setHeaderCommon('Accept', 'application/json');

    const response = await axios.post('http://localhost:8000/api/login', formState);
    isLoginError.value = false;
    authStore.setToken(response.data.access_token);

    axios.defaults.headers.common = { 'Authorization': `Bearer ${useAuthStore().token}` };

    const user = response.data.user;

    // Hanlde for basic role
    switch (user.rolename) {
      case "ADMIN":
        message.success('Đăng nhập thành công!');
        router.push({ name: 'admin-users' })
        break;
      case "USER":

        break;
      case "STAFF":

        break;
      default:
        break;
    }

  } catch (error) {
    if (error.status === 401) {
      isLoginError.value = true;
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