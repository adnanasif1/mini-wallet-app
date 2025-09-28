<template>
  <v-app-bar app color="primary" dark>
    <v-app-bar-title>My Mini Wallet</v-app-bar-title>
    <v-btn text @click="logout">Logout</v-btn>
  </v-app-bar>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { getEcho } from '@/plugins/echo'
import api from '../services/api';

const router = useRouter();
const authStore = useAuthStore();

const logout = async () => {
  try {
    await api.post('/logout', {});
    authStore.logout();
    router.push('/login');

    getEcho().disconnect();

  } catch (e: unknown) {
    console.log(e);
  }
};
</script>
