import { useState } from 'react';
import { apiClient } from '../../lib/apiClient';
import { useToast } from '../../design-system/components/Toast';

export function ReportsPage() {
  const [downloading, setDownloading] = useState(false);
  const { notify } = useToast();

  const exportCsv = async () => {
    setDownloading(true);
    try {
      const response = await apiClient.get('/reports/auctions/export', {
        responseType: 'blob'
      });
      const blob = new Blob([response.data], { type: 'text/csv;charset=utf-8;' });
      const url = window.URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', `laporan-lelang-${Date.now()}.csv`);
      document.body.appendChild(link);
      link.click();
      link.parentNode?.removeChild(link);
      notify({ title: 'Ekspor dimulai', description: 'File CSV siap diunduh' });
    } catch (error) {
      notify({ title: 'Ekspor gagal', description: 'Silakan coba kembali', status: 'error' });
    } finally {
      setDownloading(false);
    }
  };

  return (
    <div className="space-y-4">
      <h1 className="text-xl font-semibold">Pelaporan</h1>
      <p className="text-sm text-[var(--color-muted)]">
        Gunakan filter untuk mempersempit data lelang, lalu ekspor ke CSV untuk analisis lanjutan.
      </p>
      <button
        onClick={exportCsv}
        disabled={downloading}
        className="rounded-md bg-secondary-500 px-4 py-2 text-white shadow-soft disabled:opacity-50"
      >
        {downloading ? 'Mengunduh...' : 'Ekspor CSV'}
      </button>
    </div>
  );
}
