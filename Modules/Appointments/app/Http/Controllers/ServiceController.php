<?php

namespace Modules\Appointments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Appointments\Http\Requests\Service\StoreServiceRequest;
use Modules\Appointments\Http\Requests\Service\UpdateServiceRequest;
use Modules\Appointments\Models\Service;
use Modules\Appointments\Services\ServiceManager;

class ServiceController extends Controller
{
    use AuthorizesRequests;
    protected  ServiceManager $service;

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Services\ServiceManager $service
     */
    public function __construct(ServiceManager $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters=$request->only(['name','description','price']);
        $data = $this->service->getAll($filters);
        return $this->successMessage([$data], 'Successfully Get All Services', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->authorize('create', Service::class);
        $data = $this->service->store($request->validated());
        return  $this->successMessage([$data], 'Successfully Add New Service', 200);
    }

    /**
     * Show the specified resource.
     */
    public function show(Service $service)
    {
        $this->authorize('view', $service);
        $data = $this->service->get($service);
        return $this->successMessage([$data], 'Successfully Get Service', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('update', $service);
        $data = $this->service->update($request->validated(), $service);
        return $this->successMessage([$data], 'Successfully Update Service', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service  $service)
    {
        $this->authorize('delete', $service);
        $data = $this->service->destroy($service);
        return $this->successMessage([$data], 'Successfully Delete Service', 200);
    }
}
