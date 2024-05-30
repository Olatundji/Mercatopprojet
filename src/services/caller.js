
import axios from 'axios'



const Axios = axios.create({
    withCredentials: true,
    headers: {
        common:{
            Authorization: `Bearer `
        },
    },
    baseURL: 'http://localhost:8080/api'
})

// Intercepteur de réponse
axios.interceptors.response.use(
    response => response,
    error => {
      // Gérer les erreurs ici
        console.error('Erreur Axios :', error)
        return Promise.reject(error)
    }
)

export default Axios