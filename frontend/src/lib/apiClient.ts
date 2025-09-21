import axios from 'axios';
import { useAuthStore } from '../store/auth';

export const apiClient = axios.create({
  baseURL: '/api/v1',
  headers: {
    'Content-Type': 'application/json'
  }
});

apiClient.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      const refreshToken = useAuthStore.getState().refreshToken;
      if (!refreshToken) {
        useAuthStore.getState().logout();
        return Promise.reject(error);
      }

      try {
        const { data } = await apiClient.post('/auth/refresh', { refresh_token: refreshToken });
        useAuthStore.getState().setAuth({
          user: useAuthStore.getState().user!,
          token: data.data.token,
          refresh_token: data.data.refresh_token
        });
        error.config.headers.Authorization = `Bearer ${data.data.token}`;
        return apiClient.request(error.config);
      } catch (refreshError) {
        useAuthStore.getState().logout();
      }
    }

    return Promise.reject(error);
  }
);
