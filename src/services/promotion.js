
import Axios from './caller';

let CreatePromotion = () =>{
    return Axios.post('/promotions/produit/create', { // la route est à changer
        //  exemple parametre

        // nom: produit.nom,
        // prix: produit.prix,
        // description: produit.description,
        // image: produit.image,
        // qte: produit.qte,
        // idMarque: produit.marque_id,
        // idCategorie: produit.categorie_id

                code: promotions.code,
                reduction: promotions.reduction,
                date_debut: promotions.date_debut,
                date_fin: promotions.date_fin,
                idProduit: promotions.idProduit,
    })
}


let createCategoriePromotion = (code , reduction, date_debut, date_fin, idCategorie) =>{
  return Axios.post('/promotions/categorie/create', { // la route est à changer
      //  exemple parametre

      // nom: produit.nom,
      // prix: produit.prix,
      // description: produit.description,
      // image: produit.image,
      // qte: produit.qte,
      // idMarque: produit.marque_id,
      // idCategorie: produit.categorie_id

              code: code,
               reduction: reduction,
               date_debut:date_debut,
               date_fin: date_fin,
               idCategorie:idCategorie,
  })
}

let CreateMontantPromotion = (code , reduction, date_debut, date_fin, montant) =>{
  return Axios.post('/promotions/montant/create', {

              code: code,
               reduction: reduction,
               date_debut: date_debut,
               date_fin: date_fin,
               montant:montant,
  })
}


let deletePromotion = (id) => {
    return Axios.delete('/product/delete/'+ id,)
}

let allPromotion = (page = 1, limit = 10 ?? limit ) => {
    return Axios.get(`/products?page=${page}&limit=${limit}`)
}



export const promotion  = { createCategoriePromotion,CreatePromotion,CreateMontantPromotion, allPromotion, deletePromotion };
