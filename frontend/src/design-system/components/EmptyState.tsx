import { ReactNode } from 'react';
import { Inbox } from 'lucide-react';

interface EmptyStateProps {
  title: string;
  description?: string;
  action?: ReactNode;
}

export function EmptyState({ title, description, action }: EmptyStateProps) {
  return (
    <div className="flex flex-col items-center justify-center gap-3 rounded-lg border border-dashed border-[var(--color-border)] bg-[var(--color-bg)] px-6 py-10 text-center">
      <Inbox className="h-10 w-10 text-primary-500" aria-hidden="true" />
      <h3 className="text-lg font-semibold">{title}</h3>
      {description && <p className="text-sm text-[var(--color-muted)]">{description}</p>}
      {action}
    </div>
  );
}
