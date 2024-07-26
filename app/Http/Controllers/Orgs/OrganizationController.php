<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\OrganizationStoreRequest;
use App\Http\Resources\Orgs\OrganizationResource;
use App\Models\Organization;
use App\Models\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = auth()->user();
        $orgs = $user->organizations;

        return OrganizationResource::collection($orgs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationStoreRequest $request): OrganizationResource
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Organization $org */
        $org = $user->organizations()->create([
            ...$request->validated(),
            'slug' => Str::slug($request->name)
        ]);

        $org->members()->create([
            'user_id' => $user->id,
            'role' => Role::ADMIN
        ]);

        return new OrganizationResource($org);
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
