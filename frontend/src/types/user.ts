export interface User {
  id: number;
  name: string;
  email: string;
  role: 'admin' | 'staff' | 'user';
  wallet_balance?: number;
}
