<template>
  <v-app>
    <NavBar />

    <v-main class="mt-4">
  <v-container>

    <v-row>
      <v-col cols="12" md="4">
        <TransferForm />
      </v-col>
      <v-col cols="12" md="8">
        <TransactionList :userId="authStore.userId" :userName="authStore.userName" />
      </v-col>
    </v-row>
  </v-container>
  </v-main>
  </v-app>
</template>

<script setup lang="ts">
import TransferForm from './../components/TransferForm.vue';
import TransactionList from './../components/TransactionList.vue';
import NavBar from './../components/NavBar.vue';
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();
</script>
