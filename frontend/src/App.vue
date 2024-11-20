<script setup>
import { ref, provide } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import api from '@utils/api';
import '@styles/global.css';
import Header from "@components/layouts/Header.vue";

const router = useRouter();
const route = useRoute();
const routes = router.getRoutes();
const user = {
  token: localStorage.getItem('user_token'),
  name: localStorage.getItem('user_name'),
  email: localStorage.getItem('user_email')
}
provide('api', api);
provide('router', router);
provide('routes', routes);
provide('route', route)
provide('user', user);

</script>
<template>
  <Header v-if="route.name !== 'Login' && route.name !== 'Register'"></Header>

  <router-view></router-view>
</template>
<script>
export default {
  name: 'App',
  components: {
    Header
  }
};
</script>