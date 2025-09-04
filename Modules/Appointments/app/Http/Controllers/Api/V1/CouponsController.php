<?php

namespace Modules\Appointments\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Appointments\Http\Requests\Coupon\StoreCouponRequest;
use Modules\Appointments\Http\Requests\Coupon\UpdateCouponRequest;
use Modules\Appointments\Models\Coupon;
use Modules\Appointments\Services\CouponsService;

class CouponsController extends Controller
{
    use AuthorizesRequests;
    protected  CouponsService $coupons;

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Services\CouponsService $coupons
     */
    public function __construct(CouponsService $coupons)
    {
        $this->coupons = $coupons;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Coupon::class);
        $filters = $request->only('discount');
        $data = $this->coupons->getAll($filters);
        return $this->successMessage([$data], 'Successfully Get All Coupons', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        $this->authorize('create', Coupon::class);
        $data = $this->coupons->store($request->validated());
        return $this->successMessage([$data], 'SuccessFully Make New Coupon', 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Coupon $coupon)
    {
        $this->authorize('view', $coupon);
        $data = $this->coupons->get($coupon);
        return $this->successMessage([$data], 'SuccessFully Get Coupon Information', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);
        $data = $this->coupons->update($request->validated(), $coupon);
        return $this->successMessage([$data], 'Successfully Update Coupon', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);
        $this->coupons->destroy($coupon);
        return $this->successMessage(['success' => true], 'SuccessFully Delete Coupon', 200);
    }
}
