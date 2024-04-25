/* eslint-disable no-unused-vars */

import Axios from './caller';

// Axios.defaults.withCredentials = true;

let register = (user) =>{
    return Axios.post('/register',{
        nom: user.denomination,
        telephone: user.adresse,
        email: user.email,
        password: user.password
    });
}

let login = (user) => {
    return Axios.post('/login',{
        email: user.email,
        password: user.password,
    });
}


let updateProfile = (entreprise) =>{
    return Axios.patch('/updateProfile',{
        denomination: entreprise.denomination,
        adresse: entreprise.adresse,
        rccm: entreprise.rccm,
        ifu: entreprise.ifu,
        taille: entreprise.taille,
        email: entreprise.email,
    })
};

let resetPassword = (password) =>{
    return Axios.patch('/changePassword', {
        password: password
    })
}



export const account = {  register, login, updateProfile, resetPassword };