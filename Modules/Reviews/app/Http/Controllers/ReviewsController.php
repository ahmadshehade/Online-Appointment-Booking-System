<?php

namespace Modules\Reviews\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Reviews\Http\Requests\Review\ReviewStoreRequest;
use Modules\Reviews\Http\Requests\Review\ReviewUpdateRequest;
use Modules\Reviews\Models\Review;
use Modules\Reviews\Services\ReviewService;

class ReviewsController extends Controller
{
    use AuthorizesRequests;
    protected ReviewService $reviewService;

    /**
     * Summary of __construct
     * @param \Modules\Reviews\Services\ReviewService $reviewService
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $this->authorize('viewAny',Review::class);
        $filters = $request->only(['service_provider_id', 'user_id', 'rating']);
        return $this->successMessage([$this->reviewService->getAll($filters)], 'Successfully Get All Reviews', 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewStoreRequest $request)
    {  
        $this->authorize('create', Review::class);
        $review = $this->reviewService->store($request->validated());
        return $this->successMessage([$review, 'avg'=>$review->sum('rating')/$review->count()], 'Successfully Make Review', 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Review $review)
    {
        $this->authorize('view', $review);
        return $this->successMessage([$this->reviewService->get($review),'avg'=>$review->sum('rating')/$review->count()], 'Successfully get Review', 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewUpdateRequest $request, Review $review)
    {     
        $this->authorize('update', $review);
        $data = $this->reviewService->update($request->validated(), $review);
        return $this->successMessage([$data], 'Successfully Update Review', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        return $this->successMessage([$this->reviewService->destroy($review)], 'Successfully Delete Review', 200);
    }
}
