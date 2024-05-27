
import Axios from './caller';



let updateBoutique = (id, boutique) => {
    return Axios.put('/parametres/update/'+id, {
        nom: boutique.nom,
        logo: boutique.logo,
        slogan: boutique.slogan,
        adresse: boutique.adresse
    })
}

export const boutique = { updateBoutique };