/* eslint-disable no-unused-vars */

import Axios from './caller';



let createCategorieArticle = (libelle) =>{
    return Axios.post('/categoriearticles/create', {
        libelle: libelle
    })
}

let updateCategorieArticle = (id, libelle) => {
    return Axios.put('/categoriearticles/update/'+id, {
        libelle: libelle,
    })
}

let allCategorieArticle = () => {
    return Axios.get('/categoriearticles/index')
}

let deleteCategorieArticle = (id) => {
    return Axios.delete('/categoriearticles/delete/'+id)
}

export const categorie_article = { createCategorieArticle, allCategorieArticle, updateCategorieArticle, deleteCategorieArticle };