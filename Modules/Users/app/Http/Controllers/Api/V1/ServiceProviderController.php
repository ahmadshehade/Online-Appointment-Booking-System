<?php

namespace Modules\Users\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Users\Http\Requests\StoreServiceProviderRequest;
use Modules\Users\Http\Requests\UpdateServiceProviderRequest;
use Modules\Users\Models\ServiceProvider;
use Modules\Users\Services\ServiceProviderService;

class ServiceProviderController extends Controller
{
    use AuthorizesRequests;
    protected ServiceProviderService $service;


    public function __construct(ServiceProviderService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize("viewAny", ServiceProvider::class);
        $data = $this->service->getAll($filter = []);
        return $this->successMessage([$data], 'Successfully Get All Providers ', 200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceProviderRequest $request)
    {

        // $this->authorize("create", ServiceProvider::class);
        $data = $this->service->store($request->validated());
        Log::info('Store data:', $data->toArray());
        return $this->successMessage([$data], 'Successfully Add new Provider', 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(ServiceProvider $service_provider)
    {
        $this->authorize("view", $service_provider);
        $data = $this->service->get($service_provider);
        return $this->successMessage([$data], 'Successfully Get Provider information', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceProviderRequest $request, ServiceProvider $service_provider)
    {
        $this->authorize("update", $service_provider);
        $data = $this->service->update($request->validated(), $service_provider);
        return $this->successMessage([$data], 'SuccessFully Update Providers', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceProvider $service_provider)
    {
        $this->authorize("delete", $service_provider);
        $this->service->destroy($service_provider);
        return $this->successMessage([], 'Successfully Delete Provider', 200);
    }
}
