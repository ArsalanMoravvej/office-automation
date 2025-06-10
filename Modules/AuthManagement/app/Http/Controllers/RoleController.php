<?php

namespace Modules\AuthManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\AuthManagement\Http\Requests\RoleStoreRequest;
use Modules\AuthManagement\Http\Requests\RoleUpdateRequest;
use Modules\AuthManagement\Transformers\RoleResource;
use Modules\AuthManagement\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = min((int) request('per_page', 15), 100);

        $roles = QueryBuilder::for(Role::query())
            ->allowedIncludes(['permissions', 'positions.user'])
            ->allowedFilters([
                AllowedFilter::partial('name'),
            ])
            ->allowedSorts(['name'])
            ->paginate($perPage)
            ->appends(request()->query());


        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request): RoleResource
    {
        $role = Role::create($request->validated());
        return new RoleResource($role);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): RoleResource
    {
        $role = QueryBuilder::for(Role::query())
            ->allowedIncludes(['positions.user', 'permissions'])
            ->find($id);
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Role $role, RoleUpdateRequest $request): RoleResource
    {
        //

        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        $role->delete();
        return response()->json(null, 204);
    }
}
