<?php

namespace Modules\AuthManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Cassandra\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\AuthManagement\Http\Requests\PositionStoreRequest;
use Modules\AuthManagement\Http\Requests\PositionUpdateRequest;
use Modules\AuthManagement\Models\Position;
use Modules\AuthManagement\Transformers\PositionResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection

    {
        $perPage = min((int) request('per_page', 15), 100);

        $positions = QueryBuilder::for(Position::query())
            ->allowedIncludes(['user'])
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::partial('user.name'),
            ])
            ->allowedSorts(['created_at', 'title'])
            ->paginate($perPage)
            ->appends(request()->query());

        return PositionResource::collection($positions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionStoreRequest $request): PositionResource
    {
        $position =  Position::create($request->validated());
        return new PositionResource($position->refresh());
    }

    /**
     * Show the specified resource.
     */
    public function show(Position $position, Request $request): positionResource
    {
        if (request()->query('include') === 'user') {
            $position->loadMissing('user');
        }
        return new PositionResource($position);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Position $position, PositionUpdateRequest $request): PositionResource
    {
        $position->update($request->validated());
        return new PositionResource($position);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position): JsonResponse
    {
        $position->delete();
        return response()->json(null, 204);

    }
}
