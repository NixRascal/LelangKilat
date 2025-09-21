import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { apiClient } from '../../lib/apiClient';
import { DataTable } from '../../design-system/components/DataTable';
import { Modal } from '../../design-system/components/Modal';
import { useToast } from '../../design-system/components/Toast';
import { EmptyState } from '../../design-system/components/EmptyState';
import { ErrorState } from '../../design-system/components/ErrorState';
import { FormField } from '../../design-system/components/FormField';
import { Skeleton } from '../../design-system/components/Skeleton';

type Category = {
  id: number;
  name: string;
};

type Auction = {
  id: number;
  title: string;
  status: string;
  current_bid: number;
  start_time: string;
  end_time: string;
  category?: Category;
};

const schema = z.object({
  title: z.string().min(3, 'Judul minimal 3 karakter'),
  description: z.string().min(10, 'Deskripsi minimal 10 karakter'),
  starting_bid: z
    .number({ invalid_type_error: 'Tawaran awal harus berupa angka' })
    .min(10000, 'Tawaran awal minimal Rp10.000'),
  start_time: z.string().nonempty('Tanggal mulai wajib diisi'),
  end_time: z.string().nonempty('Tanggal selesai wajib diisi'),
  category_id: z
    .number({ invalid_type_error: 'Kategori wajib dipilih' })
    .min(1, 'Kategori wajib dipilih'),
});

type FormValues = z.infer<typeof schema>;

export function AuctionsPage() {
  const [page, setPage] = useState(1);
  const [open, setOpen] = useState(false);
  const queryClient = useQueryClient();
  const { notify } = useToast();

  const form = useForm<FormValues>({
    resolver: zodResolver(schema),
    defaultValues: {
      title: '',
      description: '',
      starting_bid: 10000,
      start_time: new Date().toISOString().slice(0, 16),
      end_time: new Date(Date.now() + 3600 * 1000).toISOString().slice(0, 16),
      category_id: 0,
    },
  });

  const { data: auctions, isLoading: isAuctionLoading, isError: isAuctionError, refetch } = useQuery({
    queryKey: ['auctions', page],
    queryFn: async () => {
      const { data } = await apiClient.get('/auctions', { params: { page } });
      return data;
    },
  });

  const {
    data: categories,
    isLoading: isCategoryLoading,
    isError: isCategoryError,
  } = useQuery({
    queryKey: ['categories'],
    queryFn: async () => {
      const { data } = await apiClient.get('/categories', { params: { per_page: 50 } });
      return data;
    },
    staleTime: 1000 * 60 * 5,
  });

  const mutation = useMutation({
    mutationFn: async (payload: FormValues) => {
      await apiClient.post('/auctions', payload);
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['auctions'] });
      notify({ title: 'Lelang dibuat', description: 'Lelang baru berhasil ditambahkan' });
      setOpen(false);
      form.reset({
        title: '',
        description: '',
        starting_bid: 10000,
        start_time: new Date().toISOString().slice(0, 16),
        end_time: new Date(Date.now() + 3600 * 1000).toISOString().slice(0, 16),
        category_id: 0,
      });
    },
    onError: (error: any) => {
      const message = error?.response?.data?.message ?? 'Terjadi kesalahan saat membuat lelang';
      notify({ title: 'Gagal', description: message, variant: 'error' });
    },
  });

  const categoryOptions: Category[] = categories?.data ?? [];

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h1 className="text-xl font-semibold">Daftar Lelang</h1>
        <button
          onClick={() => setOpen(true)}
          className="rounded-md bg-primary-500 px-4 py-2 text-white shadow-soft"
        >
          Tambah Lelang
        </button>
      </div>

      {isAuctionError && (
        <ErrorState
          title="Gagal memuat lelang"
          description="Silakan coba lagi beberapa saat lagi"
          action={
            <button
              onClick={() => refetch()}
              className="rounded-md border border-primary-500 px-4 py-2 text-primary-600"
            >
              Muat ulang
            </button>
          }
        />
      )}

      {isAuctionLoading ? (
        <Skeleton className="h-64 w-full" />
      ) : auctions?.data?.length === 0 ? (
        <EmptyState title="Belum ada lelang" description="Mulai dengan membuat lelang baru" />
      ) : (
        <DataTable<Auction>
          data={auctions?.data ?? []}
          columns={[
            { key: 'title', header: 'Judul' },
            { key: 'status', header: 'Status' },
            {
              key: 'category',
              header: 'Kategori',
              render: (row) => row.category?.name ?? '-',
            },
            {
              key: 'current_bid',
              header: 'Tawaran Saat Ini',
              render: (row) =>
                row.current_bid.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }),
            },
          ]}
          page={auctions?.meta?.current_page ?? 1}
          perPage={auctions?.meta?.per_page ?? 10}
          total={auctions?.meta?.total ?? 0}
          onPageChange={setPage}
        />
      )}

      <Modal open={open} onOpenChange={setOpen} title="Lelang Baru">
        {isCategoryError ? (
          <ErrorState title="Gagal memuat kategori" description="Kategori diperlukan untuk membuat lelang." />
        ) : (
          <form
            className="space-y-4"
            onSubmit={form.handleSubmit((values) => mutation.mutate(values))}
          >
            <FormField id="title" label="Judul" error={form.formState.errors.title}>
              <input
                id="title"
                className="rounded border border-[var(--color-border)] px-3 py-2"
                {...form.register('title')}
              />
            </FormField>

            <FormField id="description" label="Deskripsi" error={form.formState.errors.description}>
              <textarea
                id="description"
                className="rounded border border-[var(--color-border)] px-3 py-2"
                rows={3}
                {...form.register('description')}
              />
            </FormField>

            <div className="grid gap-4 md:grid-cols-2">
              <FormField
                id="starting_bid"
                label="Tawaran Awal"
                error={form.formState.errors.starting_bid}
              >
                <input
                  id="starting_bid"
                  type="number"
                  min={10000}
                  className="rounded border border-[var(--color-border)] px-3 py-2"
                  {...form.register('starting_bid', { valueAsNumber: true })}
                />
              </FormField>

              <FormField
                id="category_id"
                label="Kategori"
                description="Pilih kategori barang"
                error={form.formState.errors.category_id}
              >
                {isCategoryLoading ? (
                  <Skeleton className="h-10 w-full" />
                ) : (
                  <select
                    id="category_id"
                    className="rounded border border-[var(--color-border)] px-3 py-2"
                    {...form.register('category_id', { valueAsNumber: true })}
                  >
                    <option value={0} disabled>
                      Pilih kategori
                    </option>
                    {categoryOptions.map((category) => (
                      <option key={category.id} value={category.id}>
                        {category.name}
                      </option>
                    ))}
                  </select>
                )}
              </FormField>
            </div>

            <div className="grid gap-4 md:grid-cols-2">
              <FormField id="start_time" label="Mulai" error={form.formState.errors.start_time}>
                <input
                  id="start_time"
                  type="datetime-local"
                  className="rounded border border-[var(--color-border)] px-3 py-2"
                  {...form.register('start_time')}
                />
              </FormField>
              <FormField id="end_time" label="Selesai" error={form.formState.errors.end_time}>
                <input
                  id="end_time"
                  type="datetime-local"
                  className="rounded border border-[var(--color-border)] px-3 py-2"
                  {...form.register('end_time')}
                />
              </FormField>
            </div>

            <button
              type="submit"
              disabled={mutation.isLoading}
              className="w-full rounded-md bg-primary-500 px-4 py-2 text-white disabled:opacity-60"
            >
              {mutation.isLoading ? 'Menyimpan...' : 'Simpan'}
            </button>
          </form>
        )}
      </Modal>
    </div>
  );
}
