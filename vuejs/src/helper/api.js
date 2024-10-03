import { useAuthStore } from "../stores/useAuth";



export
    const api = {

        attachToken: () => {
            axios.defaults.headers.common = { 'Authorization': `Bearer ${useAuthStore().token}` };
        },


        setHeaderCommon: (key, value) => {
            axios.defaults.headers.common[key] = value;
        },
    }
