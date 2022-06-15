<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestedRideRequest;
use App\Http\Requests\UpdateRequestedRidesRequest;
use App\Models\RequestedRide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequestedRideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $requestedRides = RequestedRide::with(['offer', 'user'])->get();

        return response()->json([
            'requestedRides' => $requestedRides
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequestedRideRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequestedRideRequest $request): JsonResponse
    {
        $request->validated();
        $newRequestedRide = new RequestedRide([
            'user_id' => $request->user()->id,
            'offer_id' => $request->offer_id,
        ]);

        if ($request->info) {
            $newRequestedRide->info = $request->info;
        }

        $newRequestedRide->save();

        return response()->json([
            'requestedRide' => $newRequestedRide
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $requestedRide = RequestedRide::with(['offer', 'user'])->where('id', $id)->first();

        if (!$requestedRide->exists()) {
            return response()->json([
                'error' => 'Requested ride does not exist'
            ], 400);
        }

        return response()->json([
            'requestedRide' => $requestedRide
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequestedRidesRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequestedRidesRequest $request, int $id): JsonResponse
    {
        $request->validated();

        $requestedRide = RequestedRide::find($id);

        if (!$requestedRide->exists()) {
            return response()->json([
                'error' => 'Requested ride does not exist'
            ], 400);
        }

        $requestedRide->update([
            'info' => $request->info
        ]);

        return response()->json([
            'requestedRide' => $requestedRide
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $requestedRide = RequestedRide::find($id);

        if (!$requestedRide->exists()) {
            return response()->json([
                'error' => 'Requested ride does not exist'
            ], 400);
        }

        $requestedRide->delete();

        return response()->json([
            'message' => 'Requested ride deleted'
        ], 200);
    }
}
