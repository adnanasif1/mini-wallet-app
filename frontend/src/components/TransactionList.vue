<template>
  <v-card class="pa-4">
    <v-card-title>Transactions</v-card-title>
    <v-card-subtitle>Balance: {{ balance }}</v-card-subtitle>
    <v-card-text>
      <v-list>
        <v-list-item v-for="tx in transactions" :key="tx.id">
            <v-list-item-title>
              <span v-if="tx.sender_id === userId">Sent</span>
              <span v-else>Received</span>:
              {{ tx.amount }} (Fee: {{ tx.commission_fee }})
            </v-list-item-title>
            <v-list-item-subtitle>{{ new Date(tx.created_at).toLocaleString() }}</v-list-item-subtitle>
        </v-list-item>
      </v-list>
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { getEcho } from '@/plugins/echo'
import type { TransactionEvent } from '@/types/events'
import api from '../services/api';

const props = defineProps<{ userId: number | null }>();
const transactions = ref<TransactionEvent[]>([]);
const balance = ref(0);

const fetchTransactions = async () => {
  try {
    const res = await api.get('/transactions');
    transactions.value = res.data.transactions.data;
    balance.value = res.data.balance;
  } catch (err) {
    console.error('Failed to fetch transactions', err);
  }
};

onMounted(() => {
  fetchTransactions();

  getEcho().private(`user.${props.userId}`)
      .listen('.transaction.created', (e: TransactionEvent) => {
        transactions.value.unshift(e);
        
        if (props.userId == e.sender_id) {
          balance.value = e.sender_balance;
        } else {
          balance.value = e.receiver_balance;
        }
      });
});
</script>
