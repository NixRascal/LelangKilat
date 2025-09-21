import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { apiClient } from '../../lib/apiClient';
import { useAuthStore } from '../../store/auth';
import { useNavigate, Link } from 'react-router-dom';
import { useToast } from '../../design-system/components/Toast';

const schema = z.object({
  name: z.string().min(3, 'Minimal 3 karakter'),
  email: z.string().email('Email tidak valid'),
  password: z.string().min(8, 'Minimal 8 karakter')
});

type FormValues = z.infer<typeof schema>;

export function RegisterPage() {
  const form = useForm<FormValues>({ resolver: zodResolver(schema) });
  const navigate = useNavigate();
  const { setAuth } = useAuthStore();
  const { notify } = useToast();

  const onSubmit = async (values: FormValues) => {
    try {
      const { data } = await apiClient.post('/auth/register', values);
      setAuth(data.data);
      notify({ title: 'Registrasi berhasil', description: 'Akun Anda siap digunakan' });
      navigate('/dashboard');
    } catch (error) {
      notify({ title: 'Registrasi gagal', description: 'Periksa kembali data', status: 'error' });
    }
  };

  return (
    <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-secondary-50 to-primary-50">
      <form
        onSubmit={form.handleSubmit(onSubmit)}
        className="w-full max-w-md space-y-4 rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] p-8 shadow-soft"
        aria-labelledby="register-title"
      >
        <h1 id="register-title" className="text-2xl font-semibold text-[var(--color-text)]">
          Daftar akun baru
        </h1>
        <div className="flex flex-col gap-2">
          <label htmlFor="name" className="text-sm font-medium">
            Nama
          </label>
          <input
            id="name"
            type="text"
            className="rounded-md border border-[var(--color-border)] px-3 py-2"
            {...form.register('name')}
            aria-invalid={!!form.formState.errors.name}
          />
          {form.formState.errors.name && (
            <span className="text-xs text-red-600">{form.formState.errors.name.message}</span>
          )}
        </div>
        <div className="flex flex-col gap-2">
          <label htmlFor="email" className="text-sm font-medium">
            Email
          </label>
          <input
            id="email"
            type="email"
            className="rounded-md border border-[var(--color-border)] px-3 py-2"
            {...form.register('email')}
            aria-invalid={!!form.formState.errors.email}
          />
          {form.formState.errors.email && (
            <span className="text-xs text-red-600">{form.formState.errors.email.message}</span>
          )}
        </div>
        <div className="flex flex-col gap-2">
          <label htmlFor="password" className="text-sm font-medium">
            Kata Sandi
          </label>
          <input
            id="password"
            type="password"
            className="rounded-md border border-[var(--color-border)] px-3 py-2"
            {...form.register('password')}
            aria-invalid={!!form.formState.errors.password}
          />
          {form.formState.errors.password && (
            <span className="text-xs text-red-600">{form.formState.errors.password.message}</span>
          )}
        </div>
        <button
          type="submit"
          className="w-full rounded-md bg-secondary-500 px-4 py-2 text-white shadow-soft hover:bg-secondary-600"
        >
          Daftar
        </button>
        <div className="text-center text-sm text-[var(--color-muted)]">
          Sudah punya akun? <Link to="/login" className="text-primary-600">Masuk</Link>
        </div>
      </form>
    </div>
  );
}
