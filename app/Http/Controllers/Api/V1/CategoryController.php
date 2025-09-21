<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Category\CategoryStoreRequest;
use App\Http\Requests\Api\V1\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Support\ApiResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categories)
    {
    }

    public function index()
    {
        return ApiResponse::success(
            CategoryResource::collection($this->categories->paginate(request()->all()))
        );
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = $this->categories->create($request->validated());

        return ApiResponse::success(new CategoryResource($category), 'Kategori dibuat', Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return ApiResponse::success(new CategoryResource($category));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category = $this->categories->update($category, $request->validated());

        return ApiResponse::success(new CategoryResource($category), 'Kategori diperbarui');
    }

    public function destroy(Category $category)
    {
        $this->categories->delete($category);

        return ApiResponse::success(null, 'Kategori dihapus', Response::HTTP_NO_CONTENT);
    }
}
