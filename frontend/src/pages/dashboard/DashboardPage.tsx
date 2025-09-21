import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../../lib/apiClient';
import { EmptyState } from '../../design-system/components/EmptyState';
import { ErrorState } from '../../design-system/components/ErrorState';
import { Badge } from '../../design-system/components/Badge';
import { Skeleton } from '../../design-system/components/Skeleton';

interface DashboardResponse {
  metrics: Record<string, number>;
  trend_bid: { tanggal: string; total: number }[];
  tasks: { id: number; title: string; status: string }[];
}

export function DashboardPage() {
  const { data, isLoading, isError } = useQuery<DashboardResponse>({
    queryKey: ['dashboard'],
    queryFn: async () => {
      const { data } = await apiClient.get('/dashboard');
      return data.data;
    }
  });

  if (isLoading) {
    return <Skeleton count={4} />;
  }

  if (isError || !data) {
    return <ErrorState title="Gagal memuat dashboard" description="Coba lagi dalam beberapa saat" />;
  }

  return (
    <div className="space-y-6">
      <section aria-label="KPI utama" className="grid gap-4 md:grid-cols-4">
        {Object.entries(data.metrics).map(([key, value]) => (
          <div key={key} className="rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] p-4 shadow-soft">
            <p className="text-sm text-[var(--color-muted)]">{key.replace(/_/g, ' ')}</p>
            <p className="mt-2 text-2xl font-semibold">{value.toLocaleString('id-ID')}</p>
          </div>
        ))}
      </section>

      <section className="rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] p-4 shadow-soft">
        <h2 className="text-lg font-semibold">Tren Bid 14 Hari</h2>
        <div className="mt-4 grid gap-2 md:grid-cols-7">
          {data.trend_bid.map((item) => (
            <div key={item.tanggal} className="rounded border border-[var(--color-border)] p-3 text-center">
              <p className="text-sm text-[var(--color-muted)]">{item.tanggal}</p>
              <p className="text-xl font-semibold">{item.total}</p>
            </div>
          ))}
        </div>
      </section>

      <section className="rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] p-4 shadow-soft">
        <h2 className="text-lg font-semibold">Tugas Terbaru</h2>
        {data.tasks.length === 0 ? (
          <EmptyState title="Belum ada tugas" description="Semua lelang berjalan lancar" />
        ) : (
          <ul className="mt-4 space-y-3">
            {data.tasks.map((task) => (
              <li key={task.id} className="flex items-center justify-between rounded border border-[var(--color-border)] px-3 py-2">
                <span>{task.title}</span>
                <Badge variant={task.status === 'active' ? 'secondary' : 'neutral'}>{task.status}</Badge>
              </li>
            ))}
          </ul>
        )}
      </section>
    </div>
  );
}
