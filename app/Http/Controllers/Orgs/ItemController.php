<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Items\ItemStoreRequest;
use App\Http\Requests\Orgs\Items\ItemUpdateRequest;
use App\Http\Resources\Orgs\ItemResource;
use App\Models\Item;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org): AnonymousResourceCollection
    {
        $items = $org->items;

        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request, Organization $org): ItemResource
    {
        $item = $org->items()->create([
            ...$request->validated(),
            'category_id' => $request->category
        ]);

        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $org, Item $item) : ItemResource
    {
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemUpdateRequest $request, Organization $org, Item $item)
    {
        $response = tap($item)->update([
            $request->validated(),
            'category_id' => $request->category
        ]);
        return new ItemResource($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $org, Item $item)
    {
        $item->delete();
    }
}
