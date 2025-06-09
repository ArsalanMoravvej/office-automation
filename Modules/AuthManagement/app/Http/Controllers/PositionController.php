<?php

namespace Modules\AuthManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AuthManagement\Models\Position;
use Modules\AuthManagement\Transformers\PositionResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = QueryBuilder::for(Position::query())
            ->allowedIncludes(['user'])
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::partial('description'),
                AllowedFilter::partial('user.name'),
            ])
            ->allowedSorts(['created_at', 'title'])
            ->paginate();

        return PositionResource::collection($positions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authmanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('authmanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('authmanagement::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
