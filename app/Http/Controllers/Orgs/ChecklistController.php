<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orgs\ChecklistResource;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ChecklistController extends Controller
{
    public function index(Organization $org): AnonymousResourceCollection
    {
        $contracts = $org->contracts()->with('proposal')->latest('updated_at')->get();
        return ChecklistResource::collection($contracts);
    }
}
