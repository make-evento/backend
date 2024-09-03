<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Payable\PayableStoreRequest;
use App\Http\Resources\Orgs\PayableResource;
use App\Models\Installment;
use App\Models\Organization;
use App\Models\Payable;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PayableController extends Controller
{
    public function index(Organization $org)
    {
        $installments = Installment::where('organization_id', $org->id)
            ->where('installmentable_type', 'App\Models\Payable')
            ->orderBy('due_date', 'asc')
            ->simplePaginate(20);

        return PayableResource::collection($installments);
    }

    public function store(PayableStoreRequest $request, Organization $org)
    {
        $_r = $request->validated();
        if($_r['recipient']['type'] === 'supplier') {
            $recipient = Supplier::find($_r['recipient']['id']);
        }elseif($_r['recipient']['type'] === 'contract') {
            // 
        }

        $payable = new Payable();
        $payable->recipient()->associate($recipient);
        $payable->amount = $_r['amount'];
        $payable->payment_type = $_r['payment_type'];
        $payable->organization_id = $org->id;
        $payable->installments = count($_r['installments']);
        $payable->status = 'pending';
        $payable->save();

        foreach($_r['installments'] as $i => $_installment) {

            $installment = new Installment();
            $installment->installmentable()->associate($payable);
            $installment->installment = $i + 1;
            $installment->total_installment = count($_r['installments']);
            $installment->organization_id = $org->id;
            $installment->payment_type = $_r['payment_type'];
            $installment->amount = $_installment['amount'];
            $installment->due_date = $_installment['due_date'];
            $installment->status = ($_installment['due_date'] < date('Y-m-d')) ? 'late' : 'pending';
            $installment->save();

            if($installment->status == 'late'){
                $payable->status = 'late';
                $payable->save();
            }
        }
        return new PayableResource($payable);
    }
}
