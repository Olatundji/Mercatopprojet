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

let deleteProduit = (id, produit) => {
    return Axios.delete('/product/delete/'+ id,)
}

let allProduit = () => {
    return Axios.get('/products')
}

export const produit = { createProduit, allProduit, updateProduit, deleteProduit };