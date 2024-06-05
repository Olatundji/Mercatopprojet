
import Axios from './caller';

let createPromotion = () =>{
    return Axios.post('/product/create', { // la route est à changer 
        //  exemple parametre 

        // nom: produit.nom,
        // prix: produit.prix,
        // description: produit.description,
        // image: produit.image,
        // qte: produit.qte,
        // idMarque: produit.marque_id,
        // idCategorie: produit.categorie_id
    })
}


let deletePromotion = (id) => {
    return Axios.delete('/product/delete/'+ id,)
}

let allPromotion = (page = 1, limit = 10 ?? limit ) => {
    return Axios.get(`/products?page=${page}&limit=${limit}`)
}



export const promotion  = { createPromotion, allPromotion, deletePromotion };