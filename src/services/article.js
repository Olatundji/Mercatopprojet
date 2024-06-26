
import Axios from './caller';



let createArticle = (article) =>{
    return Axios.post('/articles/create', article)
}

let updateArticle = (id, article) => {
    return Axios.put('/articles/update/'+ id, article)
}

let showArticle = (id) => {
    return Axios.get('/articles/show/'+ id)
}

let deleteArticle = (id) => {
    return Axios.delete('/articles/delete/'+ id)
}

let allArticle = () => {
    return Axios.get(`/articles/index`)
}


export const article = { createArticle, allArticle, showArticle, updateArticle, deleteArticle };