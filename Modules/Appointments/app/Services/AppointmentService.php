<?php

namespace Modules\Appointments\Services;

use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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
        $data = parent::getAll($filters);
        return $data;
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
        return parent::destroy($model);
    }
}
