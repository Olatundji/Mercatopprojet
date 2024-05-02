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
  state() {
    return {
      sidebarVisible: '',
      sidebarUnfoldable: false,
      theme: 'light',
      token: null,
      type: null,
      user: null
    }
  },
  mutations: {
    setToken(state, token){
      state.token = token
    },
    setUser(state, user){
      state.user = user
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
  },
  actions: {},
  modules: {},
})
