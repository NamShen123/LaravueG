import { defineStore } from 'pinia';

export const useUserBooks = defineStore('user_books', {
    state: () => ({
        borring_books: {
            current_items: [],
            current_ids: [],
        },

        isFetch: false,

    }),
    actions: {
        storage: function (item) {
            this.borring_books.current_items.push(item);
            this.borring_books.current_ids.push(item.id);
        },

        remove: function (item) {
            this.borring_books.current_items = this.borring_books.current_items.filter(
                (item_arr) => {
                    return item_arr.id !== item.id;
                }
            )

            this.borring_books.current_ids = this.borring_books.current_ids.filter(
                (item_arr) => {
                    return item_arr !== item.id;
                }
            )
        },

        removeById: function (id) {
            this.borring_books.current_items = this.borring_books.current_items.filter(
                (item_arr) => {
                    return item_arr.id !== id;
                }
            )

            this.borring_books.current_ids = this.borring_books.current_ids.filter(
                (item_arr) => {
                    return item_arr !== id;
                }
            )
        },

        empty: function () {
            this.borring_books.current_items = [];
            this.borring_books.current_ids = [];
        },

        isEmpty: function () {
            return this.borring_books.current_items.length === 0;
        },

        hasBookId: function (id) {
            return this.borring_books.current_ids.includes(id);
        },

        massStorage: function (items) {

            items.forEach( (item) => {

                this.storage(item);
            })
        },

    },



});