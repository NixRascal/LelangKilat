import { Link } from 'react-router-dom';

interface Crumb {
  label: string;
  to?: string;
}

interface BreadcrumbProps {
  items: Crumb[];
}

export function Breadcrumb({ items }: BreadcrumbProps) {
  return (
    <nav aria-label="Breadcrumb" className="mb-4 text-sm text-[var(--color-muted)]">
      <ol className="flex flex-wrap items-center gap-2">
        {items.map((item, index) => (
          <li key={item.label} className="flex items-center gap-2">
            {item.to ? (
              <Link to={item.to} className="hover:text-primary-600">
                {item.label}
              </Link>
            ) : (
              <span aria-current="page" className="font-semibold text-[var(--color-text)]">
                {item.label}
              </span>
            )}
            {index < items.length - 1 && <span className="text-xs">/</span>}
          </li>
        ))}
      </ol>
    </nav>
  );
}
