import React from 'react';
import ReactDOM from 'react-dom/client';
import { RouterProvider } from 'react-router-dom';
import { QueryClientProvider } from '@tanstack/react-query';
import { routes } from './routes';
import { queryClient } from './lib/queryClient';
import './index.css';
import './design-system/theme/theme.css';
import { ToastProvider } from './design-system/components/Toast';

ReactDOM.createRoot(document.getElementById('root') as HTMLElement).render(
  <React.StrictMode>
    <QueryClientProvider client={queryClient}>
      <ToastProvider>
        <RouterProvider router={routes} />
      </ToastProvider>
    </QueryClientProvider>
  </React.StrictMode>
);
