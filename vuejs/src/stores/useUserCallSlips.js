import { defineStore } from 'pinia';

export const useUserCallSlips = defineStore('user_callSlips', {
    state: () => ({
        current_items: [],
        current_ids: [],
        error: null,

    }),
    actions: {
        storage: function (item) {
            this.current_items.push(item);
            this.current_ids.push(item.id);

        },

        remove: function (item) {
            this.current_items = this.current_items.filter(
                (item_arr) => {
                    return item_arr.id !== item.id;
                }
            )

            this.current_ids = this.current_ids.filter(
                (item_arr) => {
                    return item_arr !== item.id;
                }
            )
        },

        removeById: function (id) {
            this.current_items = this.current_items.filter(
                (item_arr) => {
                    return item_arr.id !== id;
                }
            )

            this.current_ids = this.current_ids.filter(
                (item_arr) => {
                    return item_arr !== id;
                }
            )
        },

        empty: function () {
            this.current_items = [];
            this.current_ids = [];
        },

        isEmpty: function () {
            return this.current_items.length === 0;
        },

        hasBookId: function (id) {
            return this.current_ids.includes(id);
        },

        massStorage: function (items) {

            items.forEach( (item) => {

                this.storage(item);
            })
        },
    },
});