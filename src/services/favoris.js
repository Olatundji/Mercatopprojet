
/* eslint-disable no-unused-vars */

import Axios from './caller';



let createFavoris = (id_produit, id_user) =>{
    return Axios.post('/favoris/create', {
        idProduit: id_produit,
        idUser: id_user
    })
}

let deleteFavoris = (id) => {
    return Axios.delete('/favoris/delete/'+ id,)
}

let userFavoris = (id_user) => {
    return Axios.get('/favoris/user/'+id_user)
}

export const favoris = { createFavoris, deleteFavoris, userFavoris };