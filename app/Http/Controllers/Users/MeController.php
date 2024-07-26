<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\MeResource;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function index(Request $request): MeResource
    {
        $user = $request->user();
        return new MeResource($user);
    }
}
