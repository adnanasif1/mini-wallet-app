import { defineStore } from 'pinia';

interface AuthState {
  token: string | null;
  userId: number | null;
  userName: string | null;
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    token: localStorage.getItem('token') || null,
    userId: Number(localStorage.getItem('userId')) || null,
    userName: localStorage.getItem('userName') || null
  }),
  actions: {
    setAuth(token: string, userId: number, userName: string) {
      this.token = token;
      this.userId = userId;
      this.userName = userName;
      localStorage.setItem('token', token);
      localStorage.setItem('userName', userName);
      localStorage.setItem('userId', String(userId));
    },
    logout() {
      this.token = null;
      this.userId = null;
      localStorage.removeItem('token');
      localStorage.removeItem('userName');
      localStorage.removeItem('userId');
    },
  },
});
