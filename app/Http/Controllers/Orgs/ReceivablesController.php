<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Receivable\ReceivableStoreRequest;
use App\Http\Resources\Orgs\ReceivablesResource;
use App\Models\Installment;
use App\Models\Organization;
use App\Models\Receivable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceivablesController extends Controller
{
    public function index(Organization $org)
    {
        // Criar a query base
        $receivablesQuery = Receivable::where('organization_id', $org->id)
            ->orderByRaw("CASE WHEN status = 'late' THEN 1 WHEN status = 'pending' THEN 2 WHEN status = 'paid' THEN 3 ELSE 4 END");

        // Executar a query para obter os resultados
        $receivables = $receivablesQuery->get();

        // Verificar e atualizar o status
        foreach ($receivables as $receivable) {
            $lateInstallments = $receivable->installmentsDetails()->where('status', 'late')->exists();
            if ($lateInstallments) {
                $receivable->status = 'late';
                $receivable->save();
            }
        }

        // Aplicar a paginação na query original
        $paginatedReceivables = $receivablesQuery->simplePaginate(20);

        // Retornar a coleção paginada como um recurso
        return ReceivablesResource::collection($paginatedReceivables);
    }

    public function store(ReceivableStoreRequest $request, Organization $org)
    {
        $contract = $org->contracts()->findOrFail($request->contract_id);

        $receivable = new Receivable();
        $receivable->organization_id = $org->id;
        $receivable->customer_id = $request->customer_id;
        $receivable->sender()->associate($contract);
        $receivable->amount = $contract->contractPayment->cost_total;
        $receivable->installments = count($request->installments);
        $receivable->status = ($request->first_due_date < Carbon::now()) ? 'late' : 'pending';
        $receivable->payment_type = $request->payment_type;
        $receivable->save();

        // Cria as parcelas
        foreach ($request->installments as $i => $_installment) {
            $installment = new Installment();
            $installment->installmentable()->associate($receivable); // Associa ao contrato
            $installment->installment = $i + 1;
            $installment->total_installment = count($request->installments);
            $installment->organization_id = $org->id;
            $installment->payment_type = $request->payment_type;
            $installment->amount = $_installment['amount'];
            $installment->due_date = $_installment['due_date'];
            $installment->status = ($installment->due_date->isPast()) ? 'late' : 'pending';

            $installment->save();
        }
    }

}
