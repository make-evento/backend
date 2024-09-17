<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orgs\FinancialEventsResource;
use App\Http\Resources\Orgs\FinancialResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function index(Organization $org)
    {
        return new FinancialResource($org);
    }

    public function events(Organization $org, Request $request)
    {
        if (isset($request->start_date) && isset($request->end_date)) {
            $events = $org->contracts()->whereBetween('event_date', [$request->start_date, $request->end_date])->get();
        } else {
            $events = $org->contracts()->whereBetween('event_date', [now()->startOfMonth(), now()->endOfMonth()])->get();
        }

        // Calcular totais de receivables e payables
        $totalReceivables = $events->sum(fn($contract) => $contract->contractPayment->cost_total);
        $totalPayables = $events->sum(fn($contract) =>
            $contract->todoCards->sum(fn($todoCard) => 
                $todoCard->payments->sum('amount')
            )
        );

        return [
            'receivables_total' => (float) $totalReceivables,
            'payables_total' => (float) $totalPayables,
            'total' => (float) ($totalReceivables - $totalPayables),
            'contracts' => $events->map(function ($contract) {
                return [
                    'event' => [
                        'name' => $contract->proposal->name,
                        'date' => $contract->event_date->format('d/m/Y'),
                        'type' => $contract->eventType->name,
                    ],
                    'payables' => [
                        'total' => (float) $contract->todoCards->sum(fn($todoCard) => $todoCard->payments->sum('amount')),
                        'total_paid' => (float) $contract->todoCards->sum(fn($todoCard) =>
                            $todoCard->payments->sum(fn($payment) =>
                                $payment->payables->sum(fn($payable) =>
                                    $payable->installmentsDetails()->where('status', 'paid')->sum('amount')
                                )
                            )
                        ),
                        'total_pending' => (float) $contract->todoCards->sum(fn($todoCard) =>
                            $todoCard->payments->sum(fn($payment) =>
                                $payment->payables->sum(fn($payable) =>
                                    $payable->installmentsDetails()->where('status', 'pending')->sum('amount')
                                )
                            )
                        ),
                        'total_overdue' => (float) $contract->todoCards->sum(fn($todoCard) =>
                            $todoCard->payments->sum(fn($payment) =>
                                $payment->payables->sum(fn($payable) =>
                                    $payable->installmentsDetails()->where('status', 'late')->sum('amount')
                                )
                            )
                        ),
                    ],
                    'receivables' => [
                        'total' => (float) $contract->contractPayment->cost_total,
                        'total_paid' => (float) $contract->receivables->sum(fn($receivable) =>
                            $receivable->installmentsDetails()->where('status', 'paid')->sum('amount')
                        ),
                        'total_pending' => (float) $contract->receivables->sum(fn($receivable) =>
                            $receivable->installmentsDetails()->where('status', 'pending')->sum('amount')
                        ),
                        'total_overdue' => (float) $contract->receivables->sum(fn($receivable) =>
                            $receivable->installmentsDetails()->where('status', 'late')->sum('amount')
                        ),
                    ],
                    'total' => (float) ($contract->contractPayment->cost_total - $contract->todoCards->sum(fn($todoCard) => $todoCard->payments->sum('amount')))
                ];
            })
        ];
    }
}
