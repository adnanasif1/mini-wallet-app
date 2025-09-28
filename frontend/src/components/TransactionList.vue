<template>
  <v-card class="pa-4">
    <v-card-title>Hello, {{props.userName}}! <span class="float-right text-green">Balance: {{ balance }}</span> </v-card-title>
  </v-card>
  <v-card class="pa-4 mt-4">
    <v-card-title>Transactions History:</v-card-title>
    <v-card-text>
      <v-list style="max-height: 300px; overflow-y: auto;">
        <v-list-item v-for="tx in transactions" :key="tx.id">
            <v-list-item-title>
              <span v-if="tx.sender_id === userId" class="text-red-lighten-1">Sent to user-{{ tx.receiver_id }} </span>
              <span v-else class="text-green-lighten-1">Received from user-{{ tx.sender_id }}</span>:
              {{ tx.amount }} 
                      <span v-if="tx.sender_id === userId" class="text-caption text-grey-darken-1">
            (Fee: {{ tx.commission_fee }})
        </span>

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

const props = defineProps<{ userId: number | null, userName: string | null }>();
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
