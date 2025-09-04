<?php

namespace Modules\Appointments\Services;

use App\Services\Base\BaseService;

use Modules\Appointments\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ServiceManager extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Models\Service $service
     */
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    /**
     * Summary of getAll
     * @param array $filters
     */
    public function getAll(array $filters = [])
    {
        $cacheKey = "service.index." . md5(json_encode($filters));
        Cache::tags('serviecs')->remember($cacheKey, 3600, function () use ($filters) {
            return parent::getAll($filters);
        });
    }
    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function  get(Model $model)
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
        Cache::tags('serviecs')->flush();
        $data['service_provider_id'] = Auth::user()->serviceProvider->id;
        return parent::store($data);
    }

    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model)
    {
        Cache::tags('serviecs')->flush();
        return parent::update($data, $model);
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public   function  destroy(Model $model)
    {
        Cache::tags('serviecs')->flush();
        return parent::destroy($model);
    }
}
