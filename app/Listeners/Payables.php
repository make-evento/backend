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
        $installments = $event->installments;

        // Cria um novo Payable
        $payable = new Payable();
        $payable->organization_id = $todo->organization_id;
        $payable->recipient()->associate($payment);
        $payable->amount = $payment->amount;
        $payable->installments = count($installments); // Quantidade de parcelas
        $payable->status = ($due_date < Carbon::now()) ? 'late' : 'pending';
        $payable->payment_type = $payment->payment_type;

        $payable->installments = count($installments);

        $payable->save();

        // Calcula os valores das parcelas
        $total_amount = $payment->amount;
        $installment_amount = round($total_amount / count($installments), 2);

        // Cria as parcelas
        foreach ($installments as $i => $_installment) {
            $installment = new Installment();
            $installment->installmentable()->associate($payable); // Associa ao contrato
            $installment->installment = $i + 1;
            $installment->total_installment = count($installments);
            $installment->organization_id = $todo->organization_id;
            $installment->payment_type = $payment->payment_type;
            $installment->due_date = $_installment['due_date'];
            $installment->amount = $_installment['amount']; // Usar o valor real da parcela

            $installment->save();
        }
    }
}
