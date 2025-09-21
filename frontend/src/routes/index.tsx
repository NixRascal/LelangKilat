import { createBrowserRouter, Navigate } from 'react-router-dom';
import { AppShell } from '../design-system/components/AppShell';
import { DashboardPage } from '../pages/dashboard/DashboardPage';
import { LoginPage } from '../pages/auth/LoginPage';
import { RegisterPage } from '../pages/auth/RegisterPage';
import { AuctionsPage } from '../pages/auctions/AuctionsPage';
import { UsersPage } from '../pages/dashboard/UsersPage';
import { ReportsPage } from '../pages/reports/ReportsPage';
import { SettingsPage } from '../pages/settings/SettingsPage';
import { AuditLogPage } from '../pages/audit/AuditLogPage';
import { ProtectedRoute } from './protected-route';

export const routes = createBrowserRouter([
  {
    path: '/login',
    element: <LoginPage />
  },
  {
    path: '/register',
    element: <RegisterPage />
  },
  {
    path: '/',
    element: (
      <ProtectedRoute>
        <AppShell />
      </ProtectedRoute>
    ),
    children: [
      { index: true, element: <Navigate to="/dashboard" replace /> },
      {
        path: 'dashboard',
        element: <DashboardPage />
      },
      {
        path: 'auctions',
        element: <AuctionsPage />
      },
      {
        path: 'master-data/users',
        element: (
          <ProtectedRoute roles={['admin']}>
            <UsersPage />
          </ProtectedRoute>
        )
      },
      {
        path: 'reports',
        element: (
          <ProtectedRoute roles={['admin', 'staff']}>
            <ReportsPage />
          </ProtectedRoute>
        )
      },
      {
        path: 'settings',
        element: <SettingsPage />
      },
      {
        path: 'audit-log',
        element: (
          <ProtectedRoute roles={['admin']}>
            <AuditLogPage />
          </ProtectedRoute>
        )
      }
    ]
  }
]);
