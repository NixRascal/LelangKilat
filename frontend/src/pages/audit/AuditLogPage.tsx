import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../../lib/apiClient';
import { DataTable } from '../../design-system/components/DataTable';
import { EmptyState } from '../../design-system/components/EmptyState';

interface AuditLog {
  id: number;
  module: string;
  action: string;
  description: string;
  created_at: string;
}

export function AuditLogPage() {
  const { data } = useQuery({
    queryKey: ['audit-logs'],
    queryFn: async () => {
      const { data } = await apiClient.get('/audit-logs');
      return data;
    }
  });

  if ((data?.data ?? []).length === 0) {
    return <EmptyState title="Belum ada aktivitas" description="Audit log akan muncul setelah ada aksi penting" />;
  }

  return (
    <div className="space-y-4">
      <h1 className="text-xl font-semibold">Audit Log</h1>
      <DataTable<AuditLog>
        data={data?.data ?? []}
        columns={[
          { key: 'module', header: 'Modul' },
          { key: 'action', header: 'Aksi' },
          { key: 'description', header: 'Deskripsi' },
          { key: 'created_at', header: 'Waktu' }
        ]}
        total={data?.meta?.total ?? 0}
        page={data?.meta?.current_page ?? 1}
        perPage={data?.meta?.per_page ?? 10}
      />
    </div>
  );
}
