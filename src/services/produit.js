/* eslint-disable no-unused-vars */

import Axios from './caller';



let createProduit = (produit) =>{
    return Axios.post('/product/create', {
        nom: produit.nom,
        prix: produit.prix,
        description: produit.description,
        image: produit.image,
        qte: produit.qte,
        idMarque: produit.idMarque,
        idCategorie: produit.idCategorie
    })
}

let updateProduit = (id, produit) => {
    return Axios.put('/product/update/'+ id, {
        nom: produit.nom,
        prix: produit.prix,
        description: produit.description,
        image: produit.image,
        qte: produit.qte,
        idMarque: produit.marque_id,
        idCategorie: produit.categorie_id

    })
}

let showProduit = (id) => {
    return Axios.get('/product/detail/'+id)
}

let deleteProduit = (id) => {
    return Axios.delete('/product/delete/'+ id,)
}

let allProduit = (page = 1, limit = 10 ?? limit ) => {
    return Axios.get(`/products?page=${page}&limit=${limit}`)
}

let randomProduit = (limit = 5) => {
    return Axios.get(`/limit-products?limit=${limit}`)
}

let searchProduit = (filtre) => {
    return Axios.get('/products/searchFilters', {
        idCategorie: filtre.categorie_id,
        idMarque: filtre.marque_id,
        prix_min: filtre.prix_min,
        prix_max: filtre.prix_max
    })
} 

export const produit = { createProduit, allProduit, searchProduit, updateProduit, deleteProduit, showProduit, randomProduit };