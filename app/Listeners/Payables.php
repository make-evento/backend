<?php

namespace App\Listeners;

use App\Events\TodoPaymentCreated;
use App\Models\Installment;
use App\Models\Payable;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Payables
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
    public function handle(TodoPaymentCreated $event): void
    {
        $payment = $event->payment;
        $todo = $payment->todoCard;

        $due_date = $payment->first_payment_at;
        $installments = $payment->installment;

        // Cria um novo Payable
        $payable = new Payable();
        $payable->todo_card_id = $payment->todo_card_id;
        $payable->supplier_id = $payment->supplier_id;
        $payable->amount = $payment->amount;
        $payable->installments = $installments;
        $payable->status = ($due_date < Carbon::now()) ? 'late' : 'pending';
        $payable->payment_type = $payment->payment_type;
        $payable->installments = $installments; // Set the installments property
        $payable->save();

        // Calcula os valores das parcelas
        $total_amount = $payment->amount;
        $installment_amount = round($total_amount / $installments, 2);
        $calculated_total = 0;

        // Cria as parcelas
        for ($i = 1; $i <= $installments; $i++) {
            $installment = new Installment();
            $installment->installmentable()->associate($todo); // Associa ao contrato
            $installment->installment = $i;
            $installment->total_installment = $installments;
            $installment->organization_id = $todo->organization_id;
            $installment->payment_type = $payment->payment_type;
            if($i == 1) {
                $installment->due_date = $due_date;
            } else {
                $installment->due_date = $due_date->addMonth();
            }
            if ($i == $installments) {
                // Última parcela, ajusta para cobrir qualquer diferença
                $installment->amount = $total_amount - $calculated_total;
            } else {
                $installment->amount = $installment_amount;
                $calculated_total += $installment_amount;
            }

            $installment->save();
        }
    }
}
