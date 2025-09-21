import { NavLink } from 'react-router-dom';
import { clsx } from 'clsx';
import { ShieldCheck, Users, BarChart3, Settings, FileSpreadsheet, Hammer, History } from 'lucide-react';
import { useAuthStore } from '../../store/auth';

const items = [
  { to: '/dashboard', label: 'Dashboard', icon: BarChart3, roles: ['admin', 'staff', 'user'] },
  { to: '/auctions', label: 'Lelang', icon: Hammer, roles: ['admin', 'staff', 'user'] },
  { to: '/master-data/users', label: 'Master Pengguna', icon: Users, roles: ['admin'] },
  { to: '/reports', label: 'Pelaporan', icon: FileSpreadsheet, roles: ['admin', 'staff'] },
  { to: '/settings', label: 'Pengaturan', icon: Settings, roles: ['admin', 'staff', 'user'] },
  { to: '/audit-log', label: 'Audit Log', icon: History, roles: ['admin'] }
];

export function Sidebar() {
  const { user } = useAuthStore();

  return (
    <aside className="hidden min-h-[calc(100vh-64px)] w-64 border-r border-[var(--color-border)] bg-[var(--color-bg)] px-4 py-6 md:block">
      <nav className="flex flex-col gap-2">
        {items
          .filter((item) => item.roles.includes(user?.role ?? 'user'))
          .map((item) => (
            <NavLink
              key={item.to}
              to={item.to}
              className={({ isActive }) =>
                clsx(
                  'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2',
                  isActive
                    ? 'bg-primary-500 text-white shadow-soft'
                    : 'text-[var(--color-muted)] hover:bg-primary-50 hover:text-primary-600'
                )
              }
            >
              <item.icon className="h-4 w-4" aria-hidden="true" />
              <span>{item.label}</span>
            </NavLink>
          ))}
      </nav>
    </aside>
  );
}
