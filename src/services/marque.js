/* eslint-disable no-unused-vars */

import Axios from './caller';



let createMarque = (nom) =>{
    return Axios.post('/marque', {
        nom: nom
    })
}

let updateMarque = (id, nom) => {
    return Axios.put('/marques/update/'+id, {
        nom: nom,
    })
}

let allMarque = () => {
    return Axios.get('/marques/index')
}

let deleteMarque = (id) => {
    return Axios.delete('/marques/delete/'+id)
}

export const marque = { createMarque, allMarque, updateMarque, deleteMarque };