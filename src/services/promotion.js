
import Axios from './caller';

let createProduitPromotion = (promotion) =>{
    return Axios.post('/promotions/produit/create', { 
        code: promotion.code,
        date_debut: promotion.date_debut,
        date_fin: promotion.date_fin,
        reduction: promotion.reduction,
        idProduit: promotion.idProduit,
    })
}

let createCategoriePromotion = (promotion) =>{
    return Axios.post('/promotions/produit/create', { 
        code: promotion.code,
        date_debut: promotion.date_debut,
        date_fin: promotion.date_fin,
        reduction: promotion.reduction,
        idCategorie: promotion.idCategorie,
    })
}

let createMontantPromotion = (promotion) =>{
    return Axios.post('/promotions/produit/create', { 
        code: promotion.code,
        date_debut: promotion.date_debut,
        date_fin: promotion.date_fin,
        reduction: promotion.reduction,
        montant: promotion.montant,
    })
}

let createMarquePromotion = (promotion) =>{
    return Axios.post('/promotions/produit/create', { 
        code: promotion.code,
        date_debut: promotion.date_debut,
        date_fin: promotion.date_fin,
        reduction: promotion.reduction,
        idProduit: promotion.idProduit,
    })
}

let usePromotion = (code, panier, idUser) =>{
    return Axios.post('/promotions/use', { 
        code: code,
        panier: panier,
        idUser: idUser
    })
}


let deletePromotion = (id) => {
    return Axios.delete('/product/delete/'+ id,)
}

let allPromotion = () => {
    return Axios.get('')
}



export const promotion  = { createProduitPromotion, createCategoriePromotion, createMarquePromotion, createMontantPromotion, allPromotion, deletePromotion, usePromotion };