import { Navigate, Outlet } from 'react-router-dom';
import { ReactNode } from 'react';
import { useAuthStore } from '../store/auth';
import { useToast } from '../design-system/components/Toast';

interface ProtectedRouteProps {
  children?: ReactNode;
  roles?: string[];
}

export function ProtectedRoute({ children, roles }: ProtectedRouteProps) {
  const { user, token } = useAuthStore();
  const { notify } = useToast();

  if (!token || !user) {
    return <Navigate to="/login" replace />;
  }

  if (roles && !roles.includes(user.role)) {
    notify({ title: 'Akses ditolak', description: 'Anda tidak memiliki izin', status: 'error' });
    return <Navigate to="/dashboard" replace />;
  }

  if (children) {
    return children as JSX.Element;
  }

  return <Outlet />;
}
