<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orgs\ReceivablesResource;
use App\Models\Installment;
use App\Models\Organization;
use Illuminate\Http\Request;

class ReceivablesController extends Controller
{
    public function index(Organization $org)
    {
        $installments = Installment::where('organization_id', $org->id)
            ->where('installmentable_type', 'App\Models\Contract')
            ->orderBy('due_date', 'asc')
            ->simplePaginate(20);

        return ReceivablesResource::collection($installments);
    }

}
