<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Payable\PayableStoreRequest;
use App\Http\Resources\Orgs\PayableResource;
use App\Models\Contract;
use App\Models\Installment;
use App\Models\Organization;
use App\Models\Payable;
use App\Models\Supplier;
use App\Models\TodoCardPayment;
use Illuminate\Http\Request;

class PayableController extends Controller
{
    public function index(Organization $org)
    {
        $payablesQuery = Payable::where('organization_id', $org->id)
            ->orderByRaw("CASE WHEN status = 'late' THEN 1 WHEN status = 'pending' THEN 2 WHEN status = 'paid' THEN 3 ELSE 4 END");

        $payables = $payablesQuery->get();

        foreach ($payables as $payable) {
            $lateInstallments = $payable->installmentsDetails()->where('status', 'late')->exists();
            if ($lateInstallments) {
                $payable->status = 'late';
                $payable->save();
            }
        }

        // Aplicar a paginação na consulta original antes do get()
        $paginatedPayables = $payablesQuery->simplePaginate(20);

        return PayableResource::collection($paginatedPayables);
    }

    public function store(PayableStoreRequest $request, Organization $org)
    {
        $_r = $request->validated();
        if($_r['recipient']['type'] === 'supplier') {
            $recipient = Supplier::find($_r['recipient']['id']);
        }elseif($_r['recipient']['type'] === 'contract') {
            $recipient = Contract::find($_r['recipient']['id']);
        }elseif($_r['recipient']['type'] === 'todo_card_payment') {
            $recipient = TodoCardPayment::find($_r['recipient']['id']);
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
