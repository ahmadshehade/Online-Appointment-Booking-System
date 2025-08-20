<?php

namespace Modules\Appointments\Services;

use  App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Appointments\Models\Category;

class CategoryService  extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Models\Category $category
     */
    public  function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function getAll(array $filters = [])
    {
        $cacheKey = 'categories.all';
        $cacheTTL = 3600;
        return Cache::remember($cacheKey, $cacheTTL, function () use ($filters) {
            return parent::getAll($filters);
        });
    }

    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function get(Model $model)
    {
        return parent::get($model);
    }
    /**
     * Summary of store
     * @param array $data
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function store(array $data): Model|\Illuminate\Http\JsonResponse
    {
        Cache::forget('categories.all');
        return  parent::store($data);
    }

    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model)
    {
        Cache::forget('categories.all');
        return parent::update($data, $model);
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function destroy(Model $model)
    {
        Cache::forget('categories.all');
        return parent::destroy($model);
    }
}
