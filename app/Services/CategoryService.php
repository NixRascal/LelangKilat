<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\AuditLogRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categories,
        private readonly AuditLogRepository $auditLogs,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->categories->list($filters);
    }

    public function create(array $payload): Category
    {
        $category = $this->categories->create($payload);
        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'category',
            'action' => 'create',
            'description' => 'Membuat kategori',
            'payload' => ['id' => $category->id],
        ]);

        return $category;
    }

    public function update(Category $category, array $payload): Category
    {
        $updated = $this->categories->update($category, $payload);
        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'category',
            'action' => 'update',
            'description' => 'Memperbarui kategori',
            'payload' => ['id' => $category->id],
        ]);

        return $updated;
    }

    public function delete(Category $category): void
    {
        $this->categories->delete($category);
        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'category',
            'action' => 'delete',
            'description' => 'Menghapus kategori',
            'payload' => ['id' => $category->id],
        ]);
    }
}
