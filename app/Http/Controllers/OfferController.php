<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Illuminate\Http\JsonJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $offers = Offer::with(['requests', 'user'])->get();

        return response()->json([
            'offers' => $offers
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOfferRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOfferRequest $request): JsonResponse
    {
        $request->validated();

        $newOffer = new Offer([
            'user_id' => $request->user()->id,
            'start' => $request->start,
            'finish' => $request->finish,
            'price' => $request->price,
            'space' => $request->space,
            'departure' => $request->departure,
        ]);
        $newOffer->save();

        return response()->json([
            'offer' => $newOffer
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $offer = Offer::with(['requests', 'user'])->where('id', $id)->first();

        if (!$offer->exists()) {
            return response()->json([
                'error' => 'offer does not exist'
            ], 400);
        }

        return response()->json([
            'offer' => $offer
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOfferRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOfferRequest $request, $id): JsonResponse
    {
        $request->validated();

        $offer = Offer::find($id);

        if (!$offer->exists()) {
            return response()->json([
                'error' => 'offer does not exist'
            ], 400);
        }

        $offer->update($request->all());

        return response()->json([
            'offer' => $offer
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $offer = Offer::find($id);

        if (!$offer->exists()) {
            return response()->json([
                'error' => 'offer does not exist'
            ], 400);
        }

        $offer->delete();

        return response()->json([
            'message' => 'Offer deleted'
        ], 200);
    }
}
