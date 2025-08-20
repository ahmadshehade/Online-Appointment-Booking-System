<?php

namespace Modules\Appointments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Appointments\Http\Requests\Category\CategoryStoreRequest;
use Modules\Appointments\Http\Requests\Category\CategoryUpdateRequest;
use Modules\Appointments\Models\Category;
use Modules\Appointments\Services\CategoryService;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    protected  CategoryService $categoryService;

    /**
     * Undocumented function
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->categoryService->getAll();
        return $this->successMessage([$data], 'Successfully Get All Category', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {   
        
        $this->authorize('create',Category::class);
        $data = $this->categoryService->store(($request->validated()));
        return $this->successMessage([$data], 'Successfully Make New Category', 200);
    }

    /**
     * Show the specified resource.
     */
    public function show(Category $category)
    {
        $data = $this->categoryService->get($category);
        return $this->successMessage([$data], 'Successfully get category', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $data = $this->categoryService->update($request->validated(), $category);
        return $this->successMessage([$data], 'Successfully Update Category', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $data = $this->categoryService->destroy($category);
        return $this->successMessage([$data], 'Successfully Delete Category', 200);
    }
}
