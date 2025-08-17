<?php

namespace Modules\Users\Services;

use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\AvailabilitySlot;

class AvailabilitySlotService extends BaseService
{


    /**
     * Summary of __construct
     * @param \Modules\Users\Models\AvailabilitySlot $availabilitySlot
     */
    public function __construct(AvailabilitySlot $availabilitySlot)
    {
        parent::__construct($availabilitySlot);
    }


    /**
     * Summary of getAll
     * @param array $filters
     */
    public function getAll(array $filters = [])
    {
        $query = $this->model->newQuery()->forUser(Auth::user());


        $allowedColumns = ['day_of_week', 'start_time', 'end_time'];

        return $this->getAllWithQuery($query, $filters, $allowedColumns);
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
    public function get(Model $model): Model
    {

        return parent::get($model);
    }
    /**
     * Summary of store
     * @param array $data
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function  store(array $data): Model
    {
        $data['service_provider_id'] = Auth::user()->id;
        return parent::store($data);
    }
    /**
     * Summary of update
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update(array $data, Model $model): Model
    {
        return  parent::update($data, $model);
    }

    /**
     * Summary of delete
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function destroy(Model $model): bool
    {
        return parent::destroy($model);
    }
}
