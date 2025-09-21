interface PaginationProps {
  page: number;
  total: number;
  perPage: number;
  onPageChange?: (page: number) => void;
}

export function Pagination({ page, total, perPage, onPageChange }: PaginationProps) {
  const totalPages = Math.max(1, Math.ceil(total / perPage));

  const handleClick = (nextPage: number) => {
    onPageChange?.(Math.min(Math.max(1, nextPage), totalPages));
  };

  return (
    <div className="flex items-center justify-between text-sm">
      <span>
        Halaman {page} dari {totalPages}
      </span>
      <div className="flex items-center gap-2">
        <button
          className="rounded border border-[var(--color-border)] px-3 py-1 hover:bg-primary-50"
          onClick={() => handleClick(page - 1)}
          disabled={page <= 1}
        >
          Sebelumnya
        </button>
        <button
          className="rounded border border-[var(--color-border)] px-3 py-1 hover:bg-primary-50"
          onClick={() => handleClick(page + 1)}
          disabled={page >= totalPages}
        >
          Berikutnya
        </button>
      </div>
    </div>
  );
}
