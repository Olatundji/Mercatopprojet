<template>
  <CDropdown placement="bottom-end" variant="nav-item">
    <CDropdownToggle class="py-0 pe-0" :caret="false">
      <CAvatar :src="avatar" size="md" />
    </CDropdownToggle>
    <CDropdownMenu class="pt-0">
      <CDropdownItem>
        <CIcon icon="cil-user" /> <router-link to="/admin/boutique"> Parametre du site </router-link>
      </CDropdownItem>
      <CDropdownItem>
        <CIcon icon="cil-user" /> <router-link to="/admin/profile"> Profile </router-link>
      </CDropdownItem>
      <CDropdownItem @click="logout" >
        <CIcon icon="cil-account-logout" /> Logout
      </CDropdownItem>
    </CDropdownMenu>
  </CDropdown>
</template>

<script>
import avatar from '@/assets/images/avatars/8.jpg'
import store from '@/store'

export default {
  name: 'AppHeaderDropdownAccnt',
  setup() {
    return {
      avatar: avatar,
      itemsCount: 42,
    }
  },
  methods: {
    logout(){
      store.commit('logout')
      this.$router.push('/')
    }
  },
}
</script>
