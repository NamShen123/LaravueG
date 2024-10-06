<template>
    <TheHeaderUser />

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-3 d-none d-sm-flex">
                <a-list bordered style="width: 100%;">
                    <TheMenuUser/>
                    <template #header>
                        <div>BẢNG ĐIỀU KHIỂN</div>
                    </template>
                </a-list>
            </div>

            <div class="col-12 col-sm-9">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import TheHeaderUser from '../components/TheHeaderUser.vue';
import TheMenuUser from '../components/TheMenuUser.vue';

export default {
    components: {
        TheHeaderUser,
        TheMenuUser,
    }
}
</script>