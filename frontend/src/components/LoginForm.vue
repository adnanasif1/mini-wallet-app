<template>
  <v-card class="pa-4" width="400">
    <v-card-title>Login</v-card-title>
    <v-card-text>
      <v-text-field v-model="email" label="Email" />
      <v-text-field v-model="password" label="Password" type="password" />
      <v-btn color="primary" class="mt-4" @click="login">Login</v-btn>
      <v-alert v-if="error" type="error" class="mt-2">{{ error }}</v-alert>
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';

const email = ref('');
const password = ref('');
const error = ref('');

const router = useRouter();
const authStore = useAuthStore();

const login = async () => {
  error.value = '';
  try {
    const res = await api.post('/login', { email: email.value, password: password.value });
    console.log(res);
    authStore.setAuth(res.data.token, res.data.user.id);
    router.push('/dashboard');
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Login failed';
  }
};
</script>
