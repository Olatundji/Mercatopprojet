

import router from '@/router'
import store from '@/store'

export function authGuard(role){
    const token = store.getters.getToken
    const type = store.getters.getType

    if(token){
        if(type == role){
            return true
        }else{
            router.push({name: `Login`})
        }
    }else{
        router.push({name:'Accueil'})
    }
}