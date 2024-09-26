<template>
    đây là trang quản lý roles
</template>

<script>
import { useMenu } from '../../../stores/useMenu';
export default {
    setup() {
        useMenu().onSelectedKeys(['2']);
    }
}

</script>