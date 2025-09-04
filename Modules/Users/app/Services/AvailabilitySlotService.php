<?php

namespace Modules\Users\Services;

use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Users\Models\AvailabilitySlot;

class AvailabilitySlotService extends BaseService
{


    /**
     * Summary of __construct
     * @param \Modules\Users\Models\AvailabilitySlot $availabilitySlot
     */
    public function __construct(AvailabilitySlot $availabilitySlot)
    {
        parent::__construct($availabilitySlot);
    }


    /**
     * Summary of getAll
     * @param array $filters
     */
    public function getAll(array $filters = [])
    {
        $user = Auth::user();
        $cacheKey = 'availability_slots_user_' . $user->id . '_' . md5(json_encode($filters));

        return  Cache::tags('availability_slots')->remember($cacheKey, 3600, function () use ($filters) {
            return parent::getAll($filters);
        });
    }



    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function get(Model $model): Model
    {

        return parent::get($model);
    }
    /**
     * Summary of store
     * @param array $data
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function  store(array $data): Model
    {

        $data['service_provider_id'] = Auth::user()->serviceProvider->id;
        Cache::tags('availability_slots')->flush();
        return parent::store($data);
    }
    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model): Model
    {
        Cache::tags('availability_slots')->flush();
        return  parent::update($data, $model);
    }

    /**
     * Summary of delete
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function destroy(Model $model): bool
    {
        Cache::tags('availability_slots')->flush();
        return parent::destroy($model);
    }
}
