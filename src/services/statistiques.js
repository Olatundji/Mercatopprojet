
import Axios from './caller';

let rapportVente = () =>{
    return Axios.get(`/reports/sales?date_debut=2024-5-11&date_fin=2024-6-11`, {
        date_debut: "2024-5-11",
        date_fin: "2024-6-11"
    })
}

let listeUser = () => {
    return Axios.get('/report/user-report')
} 

export const statistique  = { rapportVente, listeUser };