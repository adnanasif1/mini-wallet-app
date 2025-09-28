<template>
  <v-card class="pa-4">
    <v-card-title>Send Money</v-card-title>
    <v-card-text>
      <v-text-field v-model="receiverId" label="Receiver ID" type="number" />
      <v-text-field v-model="amount" label="Amount" type="number" />
      <v-btn color="primary" class="mt-4" @click="sendMoney">Send</v-btn>
      <v-alert v-if="error" type="error" class="mt-2">{{ error }}</v-alert>
      <v-alert v-if="success" type="success" class="mt-2">{{ success }}</v-alert>
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '../services/api';

const receiverId = ref<number | null>(null);
const amount = ref<number | null>(null);
const error = ref('');
const success = ref('');

const sendMoney = async () => {
  error.value = '';
  success.value = '';
  if (!receiverId.value || !amount.value || amount.value <= 0) {
    error.value = 'Please enter valid data';
    return;
  }
  try {
    await api.post('/transactions', {
      receiver_id: receiverId.value,
      amount: amount.value,
    });
    success.value = `Sent ${amount.value} to user ${receiverId.value}`;
    receiverId.value = null;
    amount.value = null;
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Transfer failed';
  }
};
</script>
