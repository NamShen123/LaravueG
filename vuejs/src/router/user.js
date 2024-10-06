const user = [
    {
        path: "/user",
        component: () => import('../layouts/user.vue'),
        children: [
            {
                path: "books",
                name: "user-books",
                component: () => import("../pages/user/books/index.vue")
            },
            {
                path: "callSlips",
                name: "user-call-slips",
                component: () => import("../pages/user/callSlips/index.vue")
            },
            {
                path: "account",
                name: "user-account",
                component: () => import("../pages/user/account/index.vue")
            },
        ]
    }
]

export default user;