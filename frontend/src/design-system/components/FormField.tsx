import { ReactNode } from 'react';
import { FieldError } from 'react-hook-form';

interface FormFieldProps {
  label: string;
  id: string;
  description?: string;
  error?: FieldError;
  children: ReactNode;
}

export function FormField({ label, id, description, error, children }: FormFieldProps) {
  return (
    <div className="flex flex-col gap-1">
      <label htmlFor={id} className="text-sm font-medium text-[var(--color-text)]">
        {label}
      </label>
      {description && <p className="text-xs text-[var(--color-muted)]">{description}</p>}
      {children}
      {error && <span className="text-xs text-red-600">{error.message}</span>}
    </div>
  );
}
