<template>
    đây là trang xem account
</template>

<script>
import { useMenu } from '../../../stores/useMenu';
export default {
    setup() {
        useMenu().onSelectedKeys(['3']);
    }
}

</script>