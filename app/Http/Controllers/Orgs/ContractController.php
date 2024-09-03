<?php

namespace App\Http\Controllers\Orgs;

use App\Events\ContractCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Contract\ContractStoreRequest;
use App\Models\Address;
use App\Models\Contract;
use App\Models\Item;
use App\Models\Organization;
use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\TodoCard;
use App\ProposalStatus;
use App\TodoCardStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractStoreRequest $request, Organization $org, Proposal $proposal, int $version): JsonResponse
    {
        $proposal = $proposal->version($version);

        DB::beginTransaction();

        $address = Address::query()->create($request->address);

        $eventDate = null;
        $proposalEventDay = $proposal->days()->first();

        if ($proposalEventDay) {
            $eventDate = $proposalEventDay->date;
        }

        /** @var Contract $contract */
        $contract = $org->contracts()->create([
            'proposal_id' => $proposal->id,
            'address_id' => $address->id,
            'event_type_id' => $proposal->event_type_id,
            'contract_date' => $request->contract_date,
            'event_date' => $eventDate,
            ...$request->validated('customer')
        ]);

        $payment = $request->validated('payment');
        $payment['installments_value'] = round($payment['cost_total'], 2);

        $contract->contractPayment()->create($payment);

        $proposal->update([
            'status' => ProposalStatus::APPROVED
        ]);

        /** @var ProposalItem $item */
        foreach ($proposal->items as $item) {

            /** @var TodoCard $card */
            $card = $contract->todoCards()->create([
                'organization_id' => $org->id,
                'status' => TodoCardStatus::TODO,
                'owner_id' => auth()->user()->getAuthIdentifier()
            ]);
            
            $card->item()->create([
                'item_id' => $item->item_id,
                'description' => $item->description,

                'customer_quantity' => $item->quantity,
                'customer_days' => $item->days,
                'customer_cost_per_unit' => $item->cost_per_unit,
                'customer_cost_total' => $item->cost_total,

                'supplier_quantity' => $item->quantity,
                'supplier_days' => $item->days,
                'supplier_cost_per_unit' => $item->cost_per_unit,
                'supplier_cost_total' => $item->cost_total,
            ]);
        }

        DB::commit();

        ContractCreated::dispatch(
            $contract,
            $request->installments
        );

        return response()->json($contract->load('address', 'contractPayment'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
