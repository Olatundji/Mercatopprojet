
import Axios from './caller';



let updateBoutique = (id, boutique) => {
    return Axios.put('/parametres/update/'+id, {
        nom: boutique.nom,
        logo: boutique.logo,
        slogan: boutique.slogan,
        adresse: boutique.adresse
    })
}

let getBoutiqueInfos = () => {
    return Axios.get('/parametres/show/1')
}

export const boutique = { updateBoutique, getBoutiqueInfos };