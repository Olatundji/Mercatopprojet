<template>
  <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
    <CContainer >
      <CRow class="justify-content-center">
        <CCol :md="8">
          <CCard class="p-4">
            <CCardBody>
              <div class="bg-danger" v-if="this.errors.length > 0" >
                <ul>
                  <li v-for="item in errors" :key="item.id">
                    {{ item.message }}
                  </li>
                </ul>
              </div>
              <CForm @submit.prevent="login" >
                <h1>Login</h1>
                <p class="text-body-secondary">Connecter à votre compte</p>
                <CInputGroup class="mb-3">
                  <CInputGroupText>
                    <CIcon icon="cil-envelope-closed" />
                  </CInputGroupText>
                  <CFormInput
                    type="text"
                    placeholder="Username"
                    autocomplete="username"
                    v-model="state.credentials.email"
                  />
                </CInputGroup>
                <CInputGroup class="mb-4">
                  <CInputGroupText>
                    <CIcon icon="cil-lock-locked" />
                  </CInputGroupText>
                  <CFormInput
                    type="password"
                    placeholder="Password"
                    autocomplete="current-password"
                    v-model="state.credentials.password"
                  />
                </CInputGroup>
                <CRow>
                  <CCol :xs="6">
                    <CButton type="submit" color="primary" class="px-4"> Login </CButton>
                  </CCol>
                  <CCol :xs="6" class="text-right">
                    <CButton color="link" class="px-0">
                      Forgot password?
                    </CButton>
                  </CCol>
                </CRow>
              </CForm>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import { reactive, computed } from 'vue';
import { required, email, helpers } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'LoginAdmin',
  setup() {
    const state = reactive({
      credentials:{
        email: "",
        password: ''
      }
    })

    const rules = computed(() => {
        return {
          credentials: {
                email: {
                  required: helpers.withMessage("L'email est requis", required),
                  email: helpers.withMessage("Email invalid", email)
                },
                password: {
                  required: helpers.withMessage("Le mot de passe est requis", required),
                }
              }
        }
      })

      const v$ = useVuelidate(rules, state)
      return {
        state,
        v$
      }
  },
  data() {
    return {
      errors: [],
    }
  },
  methods: {
    login(){
      this.errors = []
      this.v$.$validate()
      if(this.v$.$error){
        for (let index = 0; index < this.v$.$errors.length; index++) {
          const element = {"message": this.v$.$errors[index].$message };
          this.errors.push(element)
          
        }
      }
      console.log(this.state.credentials);
      console.log(this.errors);
    }
  }
}
</script>


