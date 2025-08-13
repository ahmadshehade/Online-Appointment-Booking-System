<?php

namespace App\Services\Base;

use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class BaseService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Summary of handle
     * @param callable $callback
     * @param string $action
     */

    protected function handle(callable $callback, string $action = 'operation')
    {
        try {
            return $callback();
        } catch (ModelNotFoundException $e) {
            Log::warning("ModelNotFoundException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (ValidationException $e) {
            Log::info("ValidationException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (AuthenticationException $e) {
            Log::warning("AuthenticationException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (AuthorizationException $e) {
            Log::warning("AuthorizationException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (ThrottleRequestsException $e) {
            Log::warning("ThrottleRequestsException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (TokenMismatchException $e) {
            Log::warning("TokenMismatchException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (QueryException $e) {
            Log::error("QueryException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (HttpResponseException $e) {
            Log::error("HttpResponseException in {$action}: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error("Exception in {$action}: " . $e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }



    /**
     * Summary of getAll
     * @param array $filters
     */
    public function getAll(array $filters = [])
    {
        return $this->handle(function () use ($filters) {

            $query = $this->model->newQuery();
            $columns = $this->model->getConnection()
                ->getSchemaBuilder()
                ->getColumnListing($this->model->getTable());

            foreach ($filters as $key => $value) {
                if (!in_array($key, $columns)) {
                    continue;
                }
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
            $results = $query->get();
            if ($results->isEmpty() && !empty($filters)) {
                throw new ModelNotFoundException("No " . $this->model::class . " records found for the given filters.");
            }

            return $results;
        }, 'getAll');
    }




    public function get(Model $model)
    {
        return $this->handle(fn() => $model, 'get');
    }

    public function store(array $data): Model|JsonResponse
    {

        return $this->handle(fn() => $this->model->create($data), 'store');
    }

    public function update(array $data, Model $model)
    {
        return $this->handle(function () use ($data, $model) {
            $model->update($data);
            return $model;
        }, 'update');
    }

    public function destroy(Model $model)
    {
        return $this->handle(fn() => $model->delete(), 'destroy');
    }
}
