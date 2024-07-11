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

let changePassword = (password, current_password, user_id) =>{
    return Axios.post('/change-password', {
        new_password: password,
        current_password: current_password,
        user_id: user_id
    })
}

let forgotPassword = (email) =>{
    return Axios.post('/forgot-password', {
        email: email
    })
}

let resetPassword = (new_password,token) =>{
    return Axios.post('/reset-password', {
        new_password: new_password,
        token: token
    })
}

let verifyToken = (token) => {
    return Axios.get('/verify-token/'+token)
}

export const auth = {  register, resetPassword, login, updateProfile, changePassword, forgotPassword, verifyToken };