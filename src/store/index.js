import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";
var ls = new SecureLS({ isCompression: false });

export default createStore({
  plugins: [
    createPersistedState({
        storage: {
        getItem: (key) => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: (key) => ls.remove(key),
        },
    }),
    ],
  state: {
    sidebarVisible: '',
    sidebarUnfoldable: false,
    theme: 'light',
    token: null,
    type: null,
    user: null,
    favori: [],
    cart: [],
  },
  mutations: {
    addToCart(state, element){
      const produitExistant = state.cart.some(p => p.id === element.id);
      if (!produitExistant) {
        state.cart.push(element)
      }
    },
    deleteToCart(state, id){
      const index = state.cart.findIndex(produit => produit.id === id);
      if (index !== -1) {
        state.cart.splice(index, 1);
      }
    },
    setToken(state, token){
      state.token = token
    },
    setType(state, type){
      state.type = type
    },
    setUser(state, user){
      state.user = user
    },
    logout(state){
      state.token = null
      state.user = null
      state.type = null
      state.cartNumber = 0
      state.cart = []
    },
    toggleSidebar(state) {
      state.sidebarVisible = !state.sidebarVisible
    },
    toggleUnfoldable(state) {
      state.sidebarUnfoldable = !state.sidebarUnfoldable
    },
    updateSidebarVisible(state, payload) {
      state.sidebarVisible = payload.value
    },
  },
  getters: {
    getCartNumber(state){
      return state.cart.length
    },
    getCartList(state){
      if (state.cart.length == 0) {
        return 0
      }else{
        return state.cart
      }
    },
    isConnect(state){
      if (state.user && state.token && state.type) {
          return state.type
      }else{
          return null
      }
    },
    getUser(state){
      return state.user
    },
    getToken(state){
      return state.token
    },
    getType(state){
      return state.type
    },
  },
  actions: {},
  modules: {},
})
