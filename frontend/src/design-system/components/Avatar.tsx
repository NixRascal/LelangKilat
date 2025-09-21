import * as RadixAvatar from '@radix-ui/react-avatar';

interface AvatarProps {
  name: string;
}

export function Avatar({ name }: AvatarProps) {
  const initials = name
    .split(' ')
    .map((part) => part[0])
    .join('')
    .slice(0, 2)
    .toUpperCase();

  return (
    <RadixAvatar.Root className="flex h-10 w-10 items-center justify-center rounded-full bg-primary-500 text-sm font-semibold text-white">
      <RadixAvatar.Fallback delayMs={300}>{initials}</RadixAvatar.Fallback>
    </RadixAvatar.Root>
  );
}
