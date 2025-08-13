<?php

namespace Modules\Users\Services;

use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
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
    
    if (empty($filters) && request()->query()) {
        $filters = request()->query();
    }

    $result = parent::getAll($filters);

    return $result->toArray();
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
        $data['user_id'] = Auth::user()->id;
        return parent::store($data);
    }


    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model): Model
    {

        return parent::update($data, $model);
    }

    /**
     * Summary of delete
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function destroy(Model $model): bool
    {

        return parent::destroy($model);
    }
}
