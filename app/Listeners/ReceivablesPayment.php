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
        $receivable->origin()->associate($event->contract);
        $receivable->amount = $contractPayment->cost_total;
        $receivable->installments = $installments;
        $receivable->status = ($due_date < Carbon::now()) ? 'late' : 'pending';
        $receivable->payment_type = $contractPayment->payment_type;
        $receivable->save();

        // Calcula os valores das parcelas
        $total_amount = $contractPayment->cost_total;
        $installment_amount = round($total_amount / $installments, 2);
        $calculated_total = 0;

        // Cria as parcelas
        for ($i = 1; $i <= $installments; $i++) {
            $installment = new Installment();
            $installment->installmentable()->associate($receivable); // Associa ao contrato
            $installment->installment = $i;
            $installment->total_installment = $installments;
            $installment->organization_id = $event->contract->organization_id;
            $installment->payment_type = $contractPayment->payment_type;
            // Define o valor da parcela
            if ($i == $installments) {
                // Última parcela, ajusta para cobrir qualquer diferença
                $installment->amount = $total_amount - $calculated_total;
            } else {
                $installment->amount = $installment_amount;
                $calculated_total += $installment_amount;
            }

            // Define a data de vencimento
            $installment_due_date = $due_date->copy()->addMonths($i - 1);
            $installment->due_date = $installment_due_date;

            // Verifica se a data de vencimento é passada
            $installment->status = ($installment_due_date->isPast()) ? 'late' : 'pending';

            $installment->save();
        }
    }
}
