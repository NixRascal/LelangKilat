import { ReactNode } from 'react';
import { clsx } from 'clsx';

interface BadgeProps {
  children: ReactNode;
  variant?: 'primary' | 'secondary' | 'neutral';
}

export function Badge({ children, variant = 'neutral' }: BadgeProps) {
  return (
    <span
      className={clsx(
        'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
        variant === 'primary' && 'bg-primary-100 text-primary-700',
        variant === 'secondary' && 'bg-secondary-100 text-secondary-700',
        variant === 'neutral' && 'bg-slate-100 text-slate-600'
      )}
    >
      {children}
    </span>
  );
}
