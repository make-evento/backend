<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orgs\PayableResource;
use App\Models\Installment;
use App\Models\Organization;
use Illuminate\Http\Request;

class PayableController extends Controller
{
    public function index(Organization $org)
    {
        $installments = Installment::where('organization_id', $org->id)
            ->where('installmentable_type', 'App\Models\TodoCard')
            ->orderBy('due_date', 'asc')
            ->simplePaginate(20);

        return PayableResource::collection($installments);
    }
}
