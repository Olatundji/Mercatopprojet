/* eslint-disable no-unused-vars */

import Axios from './caller';



let create = (contenu, user_id, article_id) =>{
    return Axios.post('/articlecommentaires/create', {
        contenu: contenu,
        idUser: user_id,
        idArticle: article_id,
    })
}

let index = () => {
    return Axios.get('/commentaires/index')
}

let deleteCommentaire = (id) => {
    return Axios.delete('/commentaires/delete/'+id)
}

export const commentaire = { create, index, deleteCommentaire };