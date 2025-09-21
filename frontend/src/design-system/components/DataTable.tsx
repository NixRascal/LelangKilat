import { ReactNode } from 'react';
import { Pagination } from './Pagination';

interface Column<T> {
  key: keyof T;
  header: string;
  render?: (row: T) => ReactNode;
}

interface DataTableProps<T> {
  data: T[];
  columns: Column<T>[];
  page?: number;
  total?: number;
  perPage?: number;
  onPageChange?: (page: number) => void;
}

export function DataTable<T extends { id: number | string }>({
  data,
  columns,
  page = 1,
  total = 0,
  perPage = 10,
  onPageChange
}: DataTableProps<T>) {
  return (
    <div className="overflow-hidden rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] shadow-soft">
      <table className="min-w-full divide-y divide-[var(--color-border)]">
        <thead className="bg-primary-50">
          <tr>
            {columns.map((column) => (
              <th key={String(column.key)} scope="col" className="px-4 py-3 text-left text-sm font-semibold text-primary-700">
                {column.header}
              </th>
            ))}
          </tr>
        </thead>
        <tbody className="divide-y divide-[var(--color-border)]">
          {data.map((row) => (
            <tr key={String(row.id)} className="hover:bg-primary-50/40 focus-within:bg-primary-50/40">
              {columns.map((column) => (
                <td key={String(column.key)} className="px-4 py-3 text-sm">
                  {column.render ? column.render(row) : String(row[column.key] ?? '')}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
      <div className="border-t border-[var(--color-border)] bg-[var(--color-bg)] px-4 py-3">
        <Pagination
          page={page}
          total={total}
          perPage={perPage}
          onPageChange={onPageChange}
        />
      </div>
    </div>
  );
}
