# Panduan Frontend React

## Struktur
```
frontend/
  src/
    design-system/  # token + komponen reusable
    hooks/          # hooks global (tema, auth)
    lib/            # apiClient & queryClient
    pages/          # halaman per fitur
    routes/         # konfigurasi routing + guard
    store/          # Zustand stores
```

## Data Fetching
- `apiClient` menggunakan Axios dengan base URL `/api/v1`.
- React Query dipakai sebagai cache & revalidate (stale time 1 menit).
- Error global ditangani `ToastProvider`.

## State Management
- Session: Zustand (`useAuthStore`).
- Data: React Query.
- Preferensi UI (tema) disimpan di localStorage (`lk-theme`).

## Komponen Desain
- `AppShell`, `Navbar`, `Sidebar`, `Breadcrumb`, `DataTable`, `FormField`, `Modal`, `Toast`, `EmptyState`, `ErrorState`, `Pagination`, `Avatar`, `Badge`.
- Tema gelap/terang otomatis via hook `useTheme`.
- Aksesibilitas: ARIA pada navigasi, focus ring 2px.

## Testing
- Jalankan `npm run test` (Vitest) untuk unit hooks/util.
- Gunakan `npm run lint` untuk memastikan konsistensi kode.

## Build
```bash
npm run build
```
Output tersedia di `frontend/dist`. Integrasikan dengan Laravel melalui CDN atau reverse proxy.
