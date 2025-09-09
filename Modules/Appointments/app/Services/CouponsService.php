<?php

namespace Modules\Appointments\Services;

use App\Models\User;
use App\Notifications\BaseNotification;
use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
    public function store(array $data): Model|JsonResponse
    {
        $data['service_provider_id'] = Auth::user()->serviceProvider->id;
        $coupon = parent::store($data);
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new BaseNotification(
                'Coupon',
                "Successfully Add Coupon: {{$coupon->code}}",
                '',
                [],
                ['mail']
            ));
        }
        Cache::tags(['coupons'])->flush();

        return $coupon;
    }

    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $data, Model $model): Model
    {
        $coupon = parent::update($data, $model);
        Cache::tags(['coupons'])->flush();
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new BaseNotification(
                'Coupon',
                "Successfully Update Coupon: {{$coupon->code}}",
                '',
                [],
                ['mail']
            ));
        }
        return $coupon->load(['serviceProvider', 'serviceProvider.user']);
    }

    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function get(Model $model): Model
    {
        $coupon = parent::get($model);

        return $coupon->load(['serviceProvider.user']);
    }

    /**
     * Summary of getAll
     * @param array $filters
     * 
     */
    public function getAll(array $filters = [])
    {
        $cacheKey = 'coupons.index.' . md5(json_encode($filters));

        return Cache::tags(['coupons'])->remember($cacheKey, 3600, function () use ($filters) {
            return parent::getAll($filters);
        });
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function destroy(Model $model): bool
    {
        $result = parent::destroy($model);

        Cache::tags(['coupons'])->flush();

        return $result;
    }
}
