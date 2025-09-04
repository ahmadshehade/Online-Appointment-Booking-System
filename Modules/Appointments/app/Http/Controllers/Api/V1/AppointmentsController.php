<?php

namespace Modules\Appointments\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Appointments\Http\Requests\Appointments\AppointmentStoreRequest;
use Modules\Appointments\Http\Requests\Appointments\AppointmentUpdateRequest;
use Modules\Appointments\Models\Appointment;
use Modules\Appointments\Services\AppointmentService;

class AppointmentsController extends Controller
{
    use AuthorizesRequests;
    protected AppointmentService $appointmentService;

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Services\AppointmentService $appointmentService
     */
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize("viewAny", Appointment::class);
        $filters = $request->only(['service_id', 'user_id']);
        return $this->successMessage([$this->appointmentService->getAll($filters)], 'Successfully Get All Appointments ', 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentStoreRequest $request)
    {
        $this->authorize('create', Appointment::class);
        $data = $this->appointmentService->store($request->validated());
        return $this->successMessage([$data], 'Successfully Add  new Appointment', 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        $data = $this->appointmentService->get($appointment);
        return $this->successMessage([$data], 'Successfully Get Appointment', 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentUpdateRequest $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $data = $this->appointmentService->update($request->validated(), $appointment);
        return $this->successMessage([$data], 'Successfully Update Appointment', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        $this->appointmentService->destroy($appointment);

        return $this->successMessage(['success' => true], 'Successfully Delete  Appointment', 200);
    }
}
