import { useAuthStore } from "../stores/useAuth";



export
    const api = {

        attachToken: () => {
            axios.defaults.headers.common = { 'Authorization': `Bearer ${useAuthStore().token}` };
        },

        setHeaderCommon: (key= 'Accept', value= 'application/json') => {
            axios.defaults.headers.common[key] = value;
        },

        clearToken: () => {
            delete axios.defaults.headers.common['Authorization'];
            useAuthStore().clearToken()
        },
    }
