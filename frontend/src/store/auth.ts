import { create } from 'zustand';
import { persist } from 'zustand/middleware';
import { User } from '../types/user';
import { apiClient } from '../lib/apiClient';
import { queryClient } from '../lib/queryClient';

interface AuthState {
  user?: User;
  token?: string;
  refreshToken?: string;
  setAuth: (payload: { user: User; token: string; refresh_token: string }) => void;
  logout: () => void;
}

export const useAuthStore = create<AuthState>()(
  persist(
    (set) => ({
      setAuth: ({ user, token, refresh_token }) => {
        apiClient.defaults.headers.common.Authorization = `Bearer ${token}`;
        set({ user, token, refreshToken: refresh_token });
      },
      logout: () => {
        set({ user: undefined, token: undefined, refreshToken: undefined });
        queryClient.clear();
      }
    }),
    {
      name: 'lk-auth',
      onRehydrateStorage: () => (state) => {
        if (state?.token) {
          apiClient.defaults.headers.common.Authorization = `Bearer ${state.token}`;
        }
      }
    }
  )
);
