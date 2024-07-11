

import router from '@/router'
import store from '@/store'
import "vue-toastification/dist/index.css";
import { useToast } from "vue-toastification";

export function authGuard(role){
    const token = store.getters.getToken
    const type = store.getters.getType

    if(token){
        if(type == role){
            return true
        }else{
            const toast = useToast();
            toast.error("Vous devez vous connecter à votre compte utilisateur pour a cette page", {
                timeout: 2000
            });
            router.push({name: `Login`})
        }
    }else{
        const toast = useToast();
        toast.error("Vous devez vous connecter à votre compte utilisateur pour a cette page", {
            timeout: 2000
        });
        router.push({name:'Accueil'})
    }
}