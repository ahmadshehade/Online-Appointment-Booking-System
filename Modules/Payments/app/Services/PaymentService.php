<?php

namespace Modules\Payments\Services;

use App\Enum\UserRoles;
use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Appointments\Models\Appointment;
use Modules\Payments\Models\Payment;

class PaymentService extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Payments\Models\Payment $model
     */
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }


    /**
     * Summary of getAll
     * @param array $filters
     * @return void
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
    public function get(Model $model) {
        return parent::get($model);
    }

    /**
     * Summary of store
     * @param array $data
     * @return JsonResponse|Model
     */
    public function store(array $data): Model
    {
        $appointment  = Appointment::findOrFail($data["appointment_id"]);
        $servicePrice = $appointment->service->price;
        $paidSoFar = $appointment->payments()->sum('amount');
        $totalPaid = $paidSoFar + $data['amount'];
        $overAmount = $totalPaid - $servicePrice;
        if ($totalPaid > $servicePrice) {
            throw new HttpResponseException(
                response()->json([
                    "message" => "You are paying more than required. Service price: {$servicePrice}, already paid: {$paidSoFar}, trying to pay: {$data['amount']}. Overpayment: {$overAmount}."

                ])
            );
        }
        $payment = parent::store($data);
        $payment->partial   = $totalPaid < $servicePrice;
        $payment->remaining = max($servicePrice - $totalPaid, 0);

        return $payment;
    }
    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     * 
     * */
    public function update(array $data, Model $model): Model
    {

        /**
         *  @var \App\Models\User|\Spatie\Permission\Traits\HasRoles $currentUser 
         */
        $currentUser = Auth::user();
        $newAppointmentId = $data['appointment_id'] ?? $model->appointment_id;
        $appointment = Appointment::findOrFail($newAppointmentId);


        if (!$currentUser->hasRole(UserRoles::SuperAdmin)) {
            if ($appointment->user_id !== $currentUser->id) {
                throw new HttpResponseException(response()->json([
                    'message' => 'You cannot transfer payment to an appointment that does not belong to you.'
                ], 403));
            }
        }

        $servicePrice = $appointment->service->price;
        $paidSoFar = $appointment->payments()->where('id', '!=', $model->id)->sum('amount');
        $newAmount = $data['amount'] ?? $model->amount;
        $totalPaid = $paidSoFar + $newAmount;

        if ($totalPaid > $servicePrice) {
            throw new HttpResponseException(response()->json([
                'message' => "You are paying more than required. Service price: {$servicePrice}, already paid: {$paidSoFar}, trying to pay: {$newAmount}. Overpayment: " . ($totalPaid - $servicePrice)
            ], 422));
        }

        $payment = parent::update($data, $model);
        $payment->partial   = $totalPaid < $servicePrice;
        $payment->remaining = max($servicePrice - $totalPaid, 0);

        return $payment;
    }
    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function destroy(Model $model)
    {
        return parent::destroy($model);
    }
}
