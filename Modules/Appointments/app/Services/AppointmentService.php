<?php

namespace Modules\Appointments\Services;

use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Appointments\Models\Appointment;

class AppointmentService extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Models\Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        parent::__construct($appointment);
    }


    /**
     * Summary of getAll
     * @param array $filters
     */
    public function getAll(array $filters = [])
    {
        $cacheKey = 'Appointment.index.' . md5(json_encode($filters));
        Cache::tags(['Appointments'])->remember($cacheKey, 3600, function () use ($filters) {
            return Appointment::all($filters);
        });
    }

    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public  function get(Model $model)
    {
        return  parent::get($model)->load(['service', 'user', 'slot', 'coupons']);
    }

    /**
     * Summary of store
     * @param array $data
     * @return JsonResponse|Model
     */
    public function store(array $data): Model|JsonResponse
    {
        Cache::tags(['Appointments'])->flush();
        $data['user_id'] = Auth::id();
        $appointment = parent::store($data);
        return $appointment->load(['service', 'user', 'slot', 'coupons']);
    }


    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model)
    {
        Cache::tags(['Appointments'])->flush();
        $appointment = parent::update($data, $model);
        $couponIds = $data['coupon_ids'] ?? [];
        $appointment->coupons()->sync($couponIds);
        return $appointment->load(['service', 'user', 'slot', 'coupons']);
    }


    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public  function destroy(Model $model)
    {
        Cache::tags(['Appointments'])->flush();
        return parent::destroy($model);
    }
}
