
import axios from 'axios'



const Axios = axios.create({
    withCredentials: true,
    headers: {
        common:{
            Authorization: `Bearer `
        },
    },
    baseURL: process.env.VUE_APP_API_URL
})

export default Axios