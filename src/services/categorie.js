/* eslint-disable no-unused-vars */

import Axios from './caller';



let createCategorie = (libelle) =>{
    return Axios.post('/categories/create', {
        libelle: libelle
    })
}

let updateCategorie = (id, libelle) => {
    return Axios.put('/categories/update/'+id, {
        libelle: libelle,
    })
}

let allCategorie = () => {
    return Axios.get('/categories/index')
}

let deleteCategorie = (id) => {
    return Axios.delete('/categories/delete/'+id)
}

export const categorie = { createCategorie, allCategorie, updateCategorie, deleteCategorie };