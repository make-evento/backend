<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\ItemCategories\ItemCategoryStoreRequest;
use App\Http\Resources\Orgs\ItemCategoryResource;
use App\Models\ItemCategory;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org): AnonymousResourceCollection
    {
        $categories = $org->itemCategories;
        return ItemCategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemCategoryStoreRequest $request, Organization $org): ItemCategoryResource
    {
        $category = $org->itemCategories()->create($request->validated());
        return new ItemCategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemCategory $itemCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategory $itemCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $itemCategory)
    {
        //
    }
}
