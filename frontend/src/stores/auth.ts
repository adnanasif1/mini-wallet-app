import { defineStore } from 'pinia';

interface AuthState {
  token: string | null;
  userId: number | null;
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    token: localStorage.getItem('token') || null,
    userId: Number(localStorage.getItem('userId')) || null,
  }),
  actions: {
    setAuth(token: string, userId: number) {
      this.token = token;
      this.userId = userId;
      localStorage.setItem('token', token);
      localStorage.setItem('userId', String(userId));
    },
    logout() {
      this.token = null;
      this.userId = null;
      localStorage.removeItem('token');
      localStorage.removeItem('userId');
    },
  },
});
