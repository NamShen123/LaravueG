import { defineStore } from 'pinia'

export const useMenu = defineStore('menuId', {
    state: () => {
        return {
            selectedKeys: [],
        }
    },

    actions: {
        onSelectedKeys(data) {
            this.selectedKeys = data;
        }
    }
})