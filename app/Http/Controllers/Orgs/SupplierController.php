<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Suppliers\SupplierStoreRequest;
use App\Http\Resources\Orgs\SupplierResource;
use App\Models\Address;
use App\Models\Organization;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org): AnonymousResourceCollection
    {
        $suppliers = $org->suppliers;
        return SupplierResource::collection($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierStoreRequest $request, Organization $org): SupplierResource
    {
        DB::beginTransaction();

        $address = Address::query()->create($request->address);

        /** @var Supplier $supplier */
        $supplier = $org->suppliers()->create([
            ...$request->validated(),
            "address_id" => $address->id,
        ]);

        $supplier->categories()->attach($request->categories);
        $supplier->bankAccounts()->createMany($request->bank_accounts);
        $supplier->contacts()->createMany($request->contacts);

        DB::commit();

        return new SupplierResource($supplier);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
