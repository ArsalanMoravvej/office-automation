<?php

namespace Modules\AuthManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\AuthManagement\Http\Requests\UserStoreRequest;
use Modules\AuthManagement\Http\Requests\UserUpdateRequest;
use Modules\AuthManagement\Transformers\UserResource;
use Psy\Util\Json;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = min((int) request('per_page', 15), 100);

        $users = QueryBuilder::for(User::query())
            ->allowedIncludes(['positions'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::partial('positions.name')
            ])
            ->allowedSorts([
                'name',
                'email',
                'positions.name',
                'created_at'
            ])
            ->paginate($perPage)
            ->appends(request()->query());

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create($request->validated());
        return new UserResource($user);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): UserResource
    {
        $user = QueryBuilder::for(User::query())
            ->allowedIncludes(['positions'])
            ->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
