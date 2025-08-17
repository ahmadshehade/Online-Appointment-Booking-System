<?php

namespace Modules\Users\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Users\Http\Requests\SlotStoreRequest;
use Modules\Users\Http\Requests\SlotUpdateRequest;
use Modules\Users\Models\AvailabilitySlot;
use Modules\Users\Services\AvailabilitySlotService;

class AvailabilitySlotController extends Controller
{

    use AuthorizesRequests;


    /**
     * Summary of availabilitySlotService
     * @var AvailabilitySlotService
     */
    protected AvailabilitySlotService $availabilitySlotService;

    /**
     * Summary of __construct
     * @param \Modules\Users\Services\AvailabilitySlotService $availabilitySlotService
     */
    public function __construct(AvailabilitySlotService $availabilitySlotService)
    {
        $this->availabilitySlotService = $availabilitySlotService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', AvailabilitySlot::class);


        $filters = $request->only(['day_of_week', 'start_time', 'end_time']);


        $slots = $this->availabilitySlotService->getAll($filters);

        return $this->successMessage($slots->toArray(), 'Successfully Get All Slots', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlotStoreRequest  $request)
    {
        $this->authorize('create', AvailabilitySlot::class);
        $slot = $this->availabilitySlotService->store($request->validated());
        return $this->successMessage([$slot], 'Successfully Add New Slot', 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(AvailabilitySlot $availability_slot)
    {
        $this->authorize('view', $availability_slot);
        $data = $this->availabilitySlotService->get($availability_slot);
        return $this->successMessage([$data], 'Successfully Get Slot', 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(SlotUpdateRequest $request, AvailabilitySlot $availability_slot)
    {
        $this->authorize('update', $availability_slot);
        $data = $this->availabilitySlotService->update($request->validated(), $availability_slot);
        return $this->successMessage([$data], 'Successfully Update Slot', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvailabilitySlot $availability_slot)
    {
        $this->authorize('delete', $availability_slot);
        $this->availabilitySlotService->destroy($availability_slot);
        return $this->successMessage(['status' => true], 'Successfully Delete Slot', 200);
    }
}
