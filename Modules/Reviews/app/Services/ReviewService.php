<?php

namespace Modules\Reviews\Services;

use App\Services\Base\BaseService;
use Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
        return parent::getAll($filters);
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
        return parent::update($data, $model);
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public  function destroy(Model $model)
    {
        return parent::destroy($model);
    }
}
