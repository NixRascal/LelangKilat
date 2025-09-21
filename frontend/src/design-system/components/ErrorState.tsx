import { ReactNode } from 'react';
import { AlertTriangle } from 'lucide-react';

interface ErrorStateProps {
  title: string;
  description?: string;
  action?: ReactNode;
}

export function ErrorState({ title, description, action }: ErrorStateProps) {
  return (
    <div className="flex flex-col items-center justify-center gap-3 rounded-lg border border-red-200 bg-red-50 px-6 py-10 text-center text-red-700">
      <AlertTriangle className="h-10 w-10" aria-hidden="true" />
      <h3 className="text-lg font-semibold">{title}</h3>
      {description && <p className="text-sm">{description}</p>}
      {action}
    </div>
  );
}
