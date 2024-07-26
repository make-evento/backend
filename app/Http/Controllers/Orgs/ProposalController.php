<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Proposal\ProposalStoreRequest;
use App\Http\Resources\Orgs\ProposalResource;
use App\Models\Organization;
use App\Models\Proposal;
use App\ProposalStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org): AnonymousResourceCollection
    {
        $proposals = $org->proposals()->where("parent_id", null)->get();
        return ProposalResource::collection($proposals);
    }

    public function versions(Organization $org, Proposal $proposal): AnonymousResourceCollection
    {
        $proposals = $org->proposals()
            ->where("parent_id", $proposal->id)
            ->orWhere("id", $proposal->id)
            ->get();
        return ProposalResource::collection($proposals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProposalStoreRequest $request, Organization $org): ProposalResource
    {
        DB::beginTransaction();

        $version = 1;

        if ($request->parent) {
            $version = $org->proposals()->where(function ($query) use ($request) {
                $query->where("id", $request->parent)
                    ->orWhere("parent_id", $request->parent);
            })->count() + 1;
        }

        /** @var Proposal $proposal */
        $proposal = $org->proposals()->create([
            ...$request->validated(),
            "version" => $version,
            "status" => ProposalStatus::PENDING,
            "parent_id" => $request->parent
        ]);

        $proposal->days()->createMany($request->days);
        $proposal->taxes()->createMany($request->taxes);
        $proposal->items()->createMany(
            collect($request->items)->map(function ($item) {
                return [
                    ...$item,
                    'item_id' => $item['id'],
                    'cost_total' => $item['cost'] * $item['quantity'] * $item['days']
                ];
            })
        );
        $proposal->customers()->attach($request->customers);

        DB::commit();

        return new ProposalResource($proposal);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $org, Proposal $proposal): ProposalResource
    {
        return new ProposalResource($proposal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        //
    }
}
