/* eslint-disable no-unused-vars */

import Axios from './caller';



let createMarque = (nom) =>{
    return Axios.post('/marque', {
        nom: nom
    })
}

let updateMarque = (nom, id) => {
    return Axios.put('/marque/'+id, {
        nom: nom,
    })
}

let allMarque = () => {
    return Axios.get('/marques')
}

let deleteMarque = (id) => {
    return Axios.delete('/marque/'+id)
}

export const marque = { createMarque, allMarque, updateMarque, deleteMarque };