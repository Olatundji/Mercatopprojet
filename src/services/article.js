
import Axios from './caller';



let createArticle = (article) =>{
    return Axios.post('/articles/create', article)
}

let updateArticle = (id, article) => {
    return Axios.put('/articles/update/'+ id, article)
}

let deleteArticle = (id) => {
    return Axios.delete('/articles/delete/'+ id)
}

let allArticle = () => {
    return Axios.get(`/articles/index`)
}

let randomProduit = (limit = 5) => {
    return Axios.get(`/limit-products?limit=${limit}`)
}

export const article = { createArticle, allArticle, updateArticle, deleteArticle, randomProduit };