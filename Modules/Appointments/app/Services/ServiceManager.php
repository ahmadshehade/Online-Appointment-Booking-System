<?php

namespace Modules\Appointments\Services;

use App\Services\Base\BaseService;

use Modules\Appointments\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Auth;
class ServiceManager extends BaseService
{

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Models\Service $service
     */
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    /**
     * Summary of getAll
     * @param array $filters
     */
    public function getAll(array $filters = [])
    {
         $query=$this->model->GetServices(Auth::user());
         $allowedColumns=['name','description','price'];
         return $this->getAllWithQuery($query, $filters,$allowedColumns);
    }


     /**
      * Summary of getAllWithQuery
      * @param mixed $query
      * @param array $filters
      * @param array $allowedColumns
      */
     protected function getAllWithQuery($query, array $filters = [], array $allowedColumns = [])
    {
        return $this->handle(function () use ($query, $filters, $allowedColumns) {


            if (empty($allowedColumns)) {
                $allowedColumns = $this->model->getConnection()
                    ->getSchemaBuilder()
                    ->getColumnListing($this->model->getTable());
            }

            foreach ($filters as $key => $value) {
                if (!in_array($key, $allowedColumns)) continue;

                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }

            $results = $query->get();

            if ($results->isEmpty() && !empty($filters)) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException(
                    "No " . $this->model::class . " records found for the given filters."
                );
            }

            return $results;
        }, 'getAll');
    }

    /**
     * Summary of get
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function  get(Model $model)
    {
        return parent::get($model);
    }

    /**
     * Summary of store
     * @param array $data
     * @return JsonResponse|Model
     */
    public function store(array $data): Model|JsonResponse
    {
        $data['service_provider_id']=Auth::user()->serviceProvider->id;
        return parent::store($data);
    }

    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model)
    {
        return parent::update($data, $model);
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public   function  destroy(Model $model)
    {
        return parent::destroy($model);
    }
}
