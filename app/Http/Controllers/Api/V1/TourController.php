<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourListRequest;
use App\Http\Resources\TourResource;
// use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;


class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Travel $travel, TourListRequest $request)
    {


        $tours = $travel->tours()
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('starting_date', '<=', $request->dateTo);
            })
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo);
            })
            ->when($request->orderBy && $request->sortOrder, function ($query) use ($request) {
                $query->where($request->orderBy, $request->sortOrder);
            })
            ->orderBy('starting_date')
            ->paginate();

        // $tours = Tour::where('travel_id', $travel->id)->orderBy('starting_date')
        //     ->paginate();

        return TourResource::collection($tours);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
