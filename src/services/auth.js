/* eslint-disable no-unused-vars */

import store from '../store';
import Axios from './caller';
// const user_id = store.getters.getUser.id

// Axios.defaults.withCredentials = true;

let register = (user) => {
    return Axios.post('/register',{
        nom: user.nom,
        numero: user.numero,
        email: user.email,
        password: user.password,
        adresse: user.adresse
    });
}

let login = (user) => {
    return Axios.post('/login',{
        email: user.email,
        password: user.password,
    });
}


let updateProfile = (user, id) =>{
    return Axios.put('/users/update/'+ id,{
        nom: user.nom,
        numero: user.numero,
        email: user.email,
        adresse: user.adresse,
    })
};

let resetPassword = (password) =>{
    return Axios.patch('/forgot-password', {
        password: password
    })
}



export const auth = {  register, login, updateProfile, resetPassword };