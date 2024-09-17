<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancialEventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'receivables_total' => (float) $this->contractPayment->cost_total,
            'payables_total' => (float) $this->todoCards->sum(fn($todoCard) => $todoCard->payments->sum('amount')),
            'total' => (float) $this->contractPayment->cost_total - $this->todoCards->sum(fn($todoCard) => $todoCard->payments->sum('amount')),
            'contracts' => [
                'event' => [
                    'name' => $this->proposal->name,
                    'date' => $this->event_date->format('d/m/Y'),
                ],
                'payables' => [
                    'total' => (float) $this->todoCards->sum(fn($todoCard) => $todoCard->payments->sum('amount')),
                    'total_paid' => (float) $this->todoCards->sum(fn($todoCard) =>
                        $todoCard->payments->sum(fn($payment) =>
                            $payment->payables->sum(fn($payable) =>
                                $payable->installmentsDetails()->where('status', 'paid')->sum('amount')
                            )
                        )
                    ),
                    'total_pending' => (float) $this->todoCards->sum(fn($todoCard) =>
                        $todoCard->payments->sum(fn($payment) =>
                            $payment->payables->sum(fn($payable) =>
                                $payable->installmentsDetails()->where('status', 'pending')->sum('amount')
                            )
                        )
                    ),
                    'total_overdue' => (float) $this->todoCards->sum(fn($todoCard) =>
                        $todoCard->payments->sum(fn($payment) =>
                            $payment->payables->sum(fn($payable) =>
                                $payable->installmentsDetails()->where('status', 'late')->sum('amount')
                            )
                        )
                    ),
                ],
                'receivables' => [
                    'total' => (float) $this->contractPayment->cost_total,
                    'total_paid' => (float) $this->receivables->sum(fn($receivable) => $receivable->installmentsDetails()->where('status', 'paid')->sum('amount')),
                    'total_pending' => (float) $this->receivables->sum(fn($receivable) => $receivable->installmentsDetails()->where('status', 'pending')->sum('amount')),
                    'total_overdue' => (float) $this->receivables->sum(fn($receivable) => $receivable->installmentsDetails()->where('status', 'late')->sum('amount')),
                ]
            ]
        ];
    }

    public function getPaidPayables($todoCard)
    {
        foreach ($todoCard as $todo) {
            foreach($todo->payments as $payment) {
                foreach($payment->payables as $payable) {
                    return $payable->installmentsDetails()->where('status', 'pending')->get();
                }
            }
        }
    }
}