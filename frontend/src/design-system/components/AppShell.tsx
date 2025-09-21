import { ReactNode } from 'react';
import { Sidebar } from './Sidebar';
import { Navbar } from './Navbar';
import { Outlet } from 'react-router-dom';

interface AppShellProps {
  children?: ReactNode;
}

export function AppShell({ children }: AppShellProps) {
  return (
    <div className="min-h-screen bg-[var(--color-bg)] text-[var(--color-text)]">
      <Navbar />
      <div className="flex">
        <Sidebar />
        <main className="flex-1 px-6 py-6" role="main">
          {children ?? <Outlet />}
        </main>
      </div>
    </div>
  );
}
