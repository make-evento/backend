<?php

namespace App\Listeners;

use App\Events\ContractCreated;
use App\Models\Installment;
use App\Models\Receivable;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReceivablesPayment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContractCreated $event): void
    {
        $contractPayment = $event->contract->contractPayment;

        $due_date = Carbon::parse($contractPayment->due_date);
        $installments = $contractPayment->installments;

        // Cria um novo Receivable
        $receivable = new Receivable();
        $receivable->organization_id = $event->contract->organization_id;
        $receivable->customer_id = $event->contract->proposal->customers->first()->id;
        $receivable->sender()->associate($event->contract);
        $receivable->amount = $contractPayment->cost_total;
        $receivable->installments = $installments;
        $receivable->status = ($due_date < Carbon::now()) ? 'late' : 'pending';
        $receivable->payment_type = $contractPayment->payment_type;
        $receivable->save();

        // Cria as parcelas
        foreach ($event->installments as $i => $_installment) {
            $installment = new Installment();
            $installment->installmentable()->associate($receivable); // Associa ao contrato
            $installment->installment = $i + 1;
            $installment->total_installment = count($event->installments);
            $installment->organization_id = $event->contract->organization_id;
            $installment->payment_type = $contractPayment->payment_type;
            $installment->amount = $_installment['amount'];
            $installment->due_date = $_installment['due_date'];
            $installment->status = ($installment->due_date->isPast()) ? 'late' : 'pending';

            $installment->save();
        }
    }
}
