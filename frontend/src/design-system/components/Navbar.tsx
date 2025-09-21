import { useAuthStore } from '../../store/auth';
import { ThemeToggle } from './ThemeToggle';
import { Avatar } from './Avatar';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from './Dropdown';
import { apiClient } from '../../lib/apiClient';
import { useToast } from './Toast';

export function Navbar() {
  const { user, logout } = useAuthStore();
  const { notify } = useToast();

  const handleLogout = async () => {
    try {
      await apiClient.post('/auth/logout');
    } finally {
      logout();
      notify({ title: 'Anda telah keluar' });
    }
  };

  return (
    <header className="sticky top-0 z-40 border-b border-[var(--color-border)] bg-[var(--color-bg)]/80 backdrop-blur">
      <div className="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <div className="flex items-center gap-3">
          <span className="rounded-full bg-primary-100 px-3 py-1 text-sm font-semibold text-primary-600">LelangKilat</span>
        </div>
        <div className="flex items-center gap-4">
          <ThemeToggle />
          <DropdownMenu>
            <DropdownMenuTrigger className="flex items-center gap-3 rounded-full border border-[var(--color-border)] bg-[var(--color-bg)] px-3 py-2 hover:bg-primary-50">
              <Avatar name={user?.name ?? 'Pengguna'} />
              <div className="hidden text-left md:block">
                <p className="text-sm font-semibold">{user?.name}</p>
                <p className="text-xs text-[var(--color-muted)]">{user?.role}</p>
              </div>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
              <DropdownMenuItem onSelect={handleLogout}>Keluar</DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </div>
    </header>
  );
}
