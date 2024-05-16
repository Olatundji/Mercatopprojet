/* eslint-disable no-unused-vars */

import Axios from './caller';



let createProduit = (produit) =>{
    return Axios.post('/product/create', {
        nom: produit.nom,
        prix: produit.prix,
        description: produit.description,
        image: produit.image,
        qte: produit.qte
    })
}

let allProduit = () => {
    return Axios.get('/products')
}

let allMarque = () => {
    return Axios.get('/listMarque')
}

let allCategorie = () => {
    return Axios.get('/listCategorie')
}
export const produit = { createProduit, allProduit, allMarque, allCategorie };