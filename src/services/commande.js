/* eslint-disable no-unused-vars */

import Axios from './caller';


let createCommande = (transaction_id, method_pay, montant, panier, user_id ) =>{
    return Axios.post('/product/create', {
        transaction: transaction_id,
        methode_pay: method_pay,
        montant: montant,
        panier: panier,
        idUser: user_id
    })
}

let showCommande = (id) => {
    return Axios.get('/product/detail/'+id)
}


let userCommandes = () => {
    return Axios.get('/products')
}

export const commande = { createCommande, userCommandes, showCommande };