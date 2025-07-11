<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Customers\CustomerStoreRequest;
use App\Http\Resources\Orgs\CustomerResource;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org): AnonymousResourceCollection
    {
        $customers = $org->customers;
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request, Organization $org): CustomerResource
    {
        $customer = $org->customers()->create(
            $request->validated()
        );

        return new CustomerResource($customer);
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
