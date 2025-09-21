import { createContext, ReactNode, useCallback, useContext, useState } from 'react';
import { CheckCircle2, AlertCircle } from 'lucide-react';
import { clsx } from 'clsx';

interface ToastMessage {
  id: number;
  title: string;
  description?: string;
  status?: 'success' | 'error';
}

interface ToastContextValue {
  notify: (message: Omit<ToastMessage, 'id'>) => void;
}

const ToastContext = createContext<ToastContextValue | undefined>(undefined);

export function ToastProvider({ children }: { children: ReactNode }) {
  const [messages, setMessages] = useState<ToastMessage[]>([]);

  const notify = useCallback((message: Omit<ToastMessage, 'id'>) => {
    setMessages((prev) => [...prev, { id: Date.now(), status: 'success', ...message }]);
    setTimeout(() => {
      setMessages((prev) => prev.slice(1));
    }, 4000);
  }, []);

  return (
    <ToastContext.Provider value={{ notify }}>
      {children}
      <div className="fixed bottom-4 right-4 flex w-80 flex-col gap-3">
        {messages.map((message) => (
          <div
            key={message.id}
            role="status"
            className={clsx(
              'flex items-start gap-3 rounded-md border px-4 py-3 shadow-soft',
              message.status === 'error'
                ? 'border-red-200 bg-red-50 text-red-700'
                : 'border-green-200 bg-green-50 text-green-700'
            )}
          >
            {message.status === 'error' ? (
              <AlertCircle className="mt-1 h-5 w-5" />
            ) : (
              <CheckCircle2 className="mt-1 h-5 w-5" />
            )}
            <div>
              <p className="text-sm font-semibold">{message.title}</p>
              {message.description && <p className="text-xs">{message.description}</p>}
            </div>
          </div>
        ))}
      </div>
    </ToastContext.Provider>
  );
}

export function useToast() {
  const ctx = useContext(ToastContext);
  if (!ctx) throw new Error('useToast harus di dalam ToastProvider');
  return ctx;
}
