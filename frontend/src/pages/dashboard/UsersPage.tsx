import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../../lib/apiClient';
import { DataTable } from '../../design-system/components/DataTable';
import { useToast } from '../../design-system/components/Toast';

interface UserRow {
  id: number;
  name: string;
  email: string;
  role: string;
}

export function UsersPage() {
  const queryClient = useQueryClient();
  const { notify } = useToast();
  const { data } = useQuery({
    queryKey: ['users'],
    queryFn: async () => {
      const { data } = await apiClient.get('/users');
      return data;
    }
  });

  const mutation = useMutation({
    mutationFn: async (id: number) => {
      await apiClient.delete(`/users/${id}`);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['users'] });
      notify({ title: 'Pengguna dihapus' });
    }
  });

  return (
    <div className="space-y-4">
      <h1 className="text-xl font-semibold">Master Pengguna</h1>
      <DataTable<UserRow>
        data={data?.data ?? []}
        columns={[
          { key: 'name', header: 'Nama' },
          { key: 'email', header: 'Email' },
          { key: 'role', header: 'Peran' },
          {
            key: 'id',
            header: 'Aksi',
            render: (row) => (
              <button
                className="rounded-md border border-red-200 px-3 py-1 text-sm text-red-600"
                onClick={() => mutation.mutate(row.id)}
              >
                Hapus
              </button>
            )
          }
        ]}
        total={data?.meta?.total ?? 0}
        page={data?.meta?.current_page ?? 1}
        perPage={data?.meta?.per_page ?? 10}
      />
    </div>
  );
}
