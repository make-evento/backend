<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancialResource extends JsonResource
{

    public function toArray(Request $request)
    {
        // Inicializando os somatórios e arrays para detalhes
        $todayReceivableCount = 0;
        $thirtyDaysReceivableCount = 0;
        $moreThanThirtyDaysReceivableCount = 0;
        $todayReceivablesDetails = [];

        $todayPayableCount = 0;
        $thirtyDaysPayableCount = 0;
        $moreThanThirtyDaysPayableCount = 0;
        $todayPayablesDetails = [];

        foreach ($this->receivables as $receivable) {
            $installmentsToday = $receivable->installmentsDetails()
                ->whereDate('due_date', now())
                ->get();

            if ($installmentsToday->isNotEmpty()) {
                $todayReceivableCount += $installmentsToday->sum('amount');

                $todayReceivablesDetails[] = new ReceivablesResource($receivable);
            }

            $thirtyDaysReceivableCount += $receivable->installmentsDetails()
                ->whereBetween('due_date', [now(), now()->addDays(30)])
                ->sum('amount');

            $moreThanThirtyDaysReceivableCount += $receivable->installmentsDetails()
                ->whereDate('due_date', '>', now()->addDays(30))
                ->sum('amount');
        }

        foreach ($this->payables as $payable) {
            $installmentsToday = $payable->installmentsDetails()
                ->whereDate('due_date', now())
                ->get();

            if ($installmentsToday->isNotEmpty()) {
                $todayPayableCount += $installmentsToday->sum('amount');

                $todayPayablesDetails[] = new PayableResource($payable);
            }
            $thirtyDaysPayableCount += $payable->installmentsDetails()
                ->whereBetween('due_date', [now(), now()->addDays(30)])
                ->sum('amount');

            $moreThanThirtyDaysPayableCount += $payable->installmentsDetails()
                ->whereDate('due_date', '>', now()->addDays(30))
                ->sum('amount');
        }

        return [
            "receivables" => [
                "today" => [
                    "total" => $todayReceivableCount,
                    "installments" => $todayReceivablesDetails, // Detalhes dos installments que vencem hoje
                ],
                "30_days" => $thirtyDaysReceivableCount,
                "more_30_days" => $moreThanThirtyDaysReceivableCount,
            ],
            "payables" => [
                "today" => [
                    "total" => $todayPayableCount,
                    "installments" => $todayPayablesDetails, // Detalhes dos installments que vencem hoje
                ],
                "30_days" => $thirtyDaysPayableCount,
                "more_30_days" => $moreThanThirtyDaysPayableCount,
            ]
        ];
    }
}
