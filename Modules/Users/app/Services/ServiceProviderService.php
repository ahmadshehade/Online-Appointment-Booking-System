<?php

namespace Modules\Users\Services;

use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Users\Models\ServiceProvider;

class ServiceProviderService extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Users\Models\ServiceProvider $service
     */
    public function __construct(ServiceProvider $service)
    {
        parent::__construct($service);
    }

    /**
     * Summary of getAll
     *
     */
    public function getAll(array $filters = []): array
    {

        $user = Auth::user();
        $cacheKey = 'serviceProvider_userId' . $user->id . '_' . md5(json_encode($filters));
        return Cache::tags('service_providers')->remember($cacheKey, 3600, function () use ($filters) {
            return parent::getAll($filters);
        });
    }

    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function get(Model $model): Model
    {
        $modelWithUser = $model->load('user');
        return parent::get($modelWithUser);
    }

    /**
     * Summary of store
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function  store(array $data): Model
    {
        $serviceProvider = ServiceProvider::where('user_id', Auth::id())->first();
        if ($serviceProvider) {
            throw new HttpResponseException(response()->json(
                ['message' => 'User Already Provider'],
                403
            ));
        }
        $data['user_id'] = Auth::user()->id;
        $serviceProvider = parent::store($data);
        Cache::tags(['service_providers'])->flush();
        return $serviceProvider;
    }


    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model): Model
    {

        Cache::tags('service_providers')->flush();
        return parent::update($data, $model);
    }

    /**
     * Summary of delete
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function destroy(Model $model): bool
    {

        Cache::tags('service_providers')->flush();
        return parent::destroy($model);
    }
}
