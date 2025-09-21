import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../../lib/apiClient';
import { useToast } from '../../design-system/components/Toast';

export function SettingsPage() {
  const queryClient = useQueryClient();
  const { notify } = useToast();
  const { data } = useQuery({
    queryKey: ['settings'],
    queryFn: async () => {
      const { data } = await apiClient.get('/settings/profile');
      return data.data;
    }
  });

  const mutation = useMutation({
    mutationFn: async (payload: Record<string, string>) => {
      await apiClient.patch('/settings/preferences', payload);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['settings'] });
      notify({ title: 'Preferensi disimpan' });
    }
  });

  return (
    <div className="space-y-4">
      <h1 className="text-xl font-semibold">Pengaturan</h1>
      <div className="rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] p-4 shadow-soft">
        <h2 className="text-lg font-semibold">Profil</h2>
        <p className="text-sm text-[var(--color-muted)]">{data?.user?.email}</p>
      </div>
      <div className="rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] p-4 shadow-soft">
        <h2 className="text-lg font-semibold">Preferensi</h2>
        <button
          onClick={() => mutation.mutate({ theme: data?.preferences?.theme === 'dark' ? 'light' : 'dark' })}
          className="rounded-md bg-primary-500 px-4 py-2 text-white"
        >
          Ganti Tema ke {data?.preferences?.theme === 'dark' ? 'Terang' : 'Gelap'}
        </button>
      </div>
    </div>
  );
}
