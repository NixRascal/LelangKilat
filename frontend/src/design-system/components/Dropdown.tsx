import * as Dropdown from '@radix-ui/react-dropdown-menu';
import { ReactNode } from 'react';

export const DropdownMenu = Dropdown.Root;
export const DropdownMenuTrigger = Dropdown.Trigger;

export function DropdownMenuContent({ children, align = 'center' }: { children: ReactNode; align?: 'center' | 'start' | 'end' }) {
  return (
    <Dropdown.Content
      align={align}
      sideOffset={8}
      className="z-50 min-w-[180px] rounded-md border border-[var(--color-border)] bg-[var(--color-bg)] p-1 shadow-soft"
    >
      {children}
    </Dropdown.Content>
  );
}

export function DropdownMenuItem({ children, onSelect }: { children: ReactNode; onSelect?: () => void }) {
  return (
    <Dropdown.Item
      onSelect={onSelect}
      className="flex cursor-pointer items-center rounded px-3 py-2 text-sm outline-none hover:bg-primary-50 hover:text-primary-600"
    >
      {children}
    </Dropdown.Item>
  );
}
