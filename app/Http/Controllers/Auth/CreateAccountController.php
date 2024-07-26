<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateAccountController extends Controller
{
    public function store(CreateAccountRequest $request): JsonResponse
    {
        User::query()->create($request->validated());
        return response()->json("Account created", Response::HTTP_CREATED);
    }
}
