<?php

namespace Modules\Payments\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Payments\Http\Requests\Payment\PaymentStoreRequest;
use Modules\Payments\Http\Requests\Payment\PaymentUpdateRequest;
use Modules\Payments\Models\Payment;
use Modules\Payments\Services\PaymentService;

class PaymentsController extends Controller
{
    use AuthorizesRequests;
    protected PaymentService $paymentService;

    /**
     * PaymentsController constructor.
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Payment::class);
        $filters = $request->only(['appointment_id', 'status']);

        return $this->successMessage(
            [$this->paymentService->getAll($filters)],
            'Payments retrieved successfully.',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request)
    {
        $this->authorize('create', Payment::class);

        $payment = $this->paymentService->store($request->validated());

        return $this->successMessage(
            [$payment],
            'Payment created successfully.',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        return $this->successMessage(
            [$this->paymentService->get($payment)],
            'Payment retrieved successfully.',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentUpdateRequest $request, Payment $payment)
    {
        $this->authorize('update', $payment);

        $updatedPayment = $this->paymentService->update($request->validated(), $payment);

        return $this->successMessage(
            [$updatedPayment],
            'Payment updated successfully.',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);

        $this->paymentService->destroy($payment);

        return $this->successMessage(
            ['success' => true],
            'Payment deleted successfully.',
            200
        );
    }
}
