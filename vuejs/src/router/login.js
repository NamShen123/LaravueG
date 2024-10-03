const login = [
    {
        path: "/login",
        name: "login",
        component: () => import('../pages/auth/Login.vue'),
    },
    {
        path: "/",
        redirect: "/login",
    }
]

export default login;