interface SkeletonProps {
  count?: number;
}

export function Skeleton({ count = 1 }: SkeletonProps) {
  return (
    <div className="space-y-3">
      {Array.from({ length: count }).map((_, index) => (
        <div key={index} className="h-16 w-full animate-pulse rounded-lg bg-slate-200 dark:bg-slate-700" />
      ))}
    </div>
  );
}
