<?php

namespace Modules\Appointments\Services;

use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Appointments\Models\Coupon;

class CouponsService extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Models\Coupon $service
     */
    public function __construct(Coupon $service)
    {
        parent::__construct($service);
    }


    /**
     * Summary of store
     * @param array $data
     * @return JsonResponse|Model
     */
    public function  store(array $data): Model|JsonResponse
    {
        $data['service_provider_id']=Auth::user()->serviceProvider->id;
        $data = parent::store($data);
        return $data;
    }

    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public  function update(array $data, Model $model)
    {
        $data = parent::update($data, $model);
        return $data->load(['serviceProvider','serviceProvider.user']);
    }

    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function  get(Model $model)
    {
        $data = parent::get($model);
        return $data->load(['serviceProvider.user']);
    }

    /**
     * Summary of getAll
     * @param array $filters
     */
    public  function  getAll(array $filters = [])
    {
        $data = parent::getAll($filters);
        return $data;
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function  destroy(Model $model)
    {
        return parent::destroy($model);
    }
}
