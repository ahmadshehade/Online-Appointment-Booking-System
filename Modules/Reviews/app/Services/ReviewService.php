<?php

namespace Modules\Reviews\Services;

use App\Services\Base\BaseService;
use Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ReviewService extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Reviews\Models\Review $review
     */
    public function __construct(Review $review)
    {
        parent::__construct($review);
    }

    /**
     * Summary of getAll
     * @param array $filters
     */
    public function getAll(array $filters = [])
    {
        $cacheKey = 'reviews.index' . md5(json_encode($filters));
        Cache::tags(['reviews'])->remember($cacheKey, 3600, function () use ($filters) {
            return parent::getAll($filters);
        });
    }

    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public  function  get(Model $model)
    {
        return parent::get($model);
    }

    /**
     * Summary of store
     * @param array $data
     * @return JsonResponse|Model
     */
    public function store(array $data): Model|JsonResponse
    {
        Cache::tags(['reviews'])->flush();
        $data['user_id'] = Auth::id();
        return parent::store($data);
    }

    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model)
    {
        Cache::tags(['reviews'])->flush();
        return parent::update($data, $model);
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public  function destroy(Model $model)
    {
        Cache::tags(['reviews'])->flush();
        return parent::destroy($model);
    }
}
