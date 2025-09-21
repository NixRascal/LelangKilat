# Dokumen API LelangKilat

- Spesifikasi lengkap: [`openapi.yaml`](./openapi.yaml)
- Endpoint base: `/api/v1`
- Autentikasi: Bearer token dari Laravel Sanctum. Gunakan header `Authorization: Bearer {token}`.
- Rate limit default: 120 request per menit per token.

## Contoh cURL

```bash
# Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H 'Content-Type: application/json' \
  -d '{"email":"admin@qa.test","password":"password123"}'

# Mendapatkan daftar lelang
curl -X GET http://localhost:8000/api/v1/auctions?page=1 \
  -H 'Authorization: Bearer {TOKEN}'

# Mendapatkan daftar kategori
curl -X GET http://localhost:8000/api/v1/categories \
  -H 'Authorization: Bearer {TOKEN}'

# Membuat lelang baru
curl -X POST http://localhost:8000/api/v1/auctions \
  -H 'Authorization: Bearer {TOKEN}' \
  -H 'Content-Type: application/json' \
  -d '{
    "title": "Laptop Gaming",
    "description": "Laptop bekas mulus",
    "starting_bid": 2500000,
    "start_time": "2025-05-21T09:00:00+07:00",
    "end_time": "2025-05-23T09:00:00+07:00",
    "status": "active",
    "category_id": 1
  }'
```

## Contoh Konsumsi dengan Axios

```ts
import axios from 'axios';

const api = axios.create({ baseURL: '/api/v1' });

api.interceptors.request.use((config) => {
  config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`;
  return config;
});

async function getAuctions() {
  const { data } = await api.get('/auctions', { params: { page: 1 } });
  return data;
}
```
