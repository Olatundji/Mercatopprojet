/* eslint-disable no-unused-vars */

import Axios from './caller';


let createCommande = (transaction_id, method_pay, montant, panier, user_id ) =>{
    return Axios.post('/commande/create', {
        transaction: transaction_id,
        method_pay: method_pay,
        montant: montant,
        panier: panier,
        idUser: user_id
    })
}

let allCommandes = () => {
    return Axios.get('/commande/index')
}

let validateCommande = (id) => {
    return Axios.post('/admin/valider-commande/' + id)
} 

let showCommande = (id) => {
    return Axios.get('/commande/detail/'+id)
}


let userCommandes = (user_id) => {
    return Axios.get('/commande/user/'+user_id)
}

export const commande = { createCommande, userCommandes, showCommande, allCommandes, validateCommande };