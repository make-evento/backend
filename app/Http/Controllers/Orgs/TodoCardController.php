<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Todo\TodoUpdateOwnerRequest;
use App\Http\Requests\Orgs\Todo\TodoUpdateRequest;
use App\Http\Requests\Orgs\Todo\TodoUpdateSupplierRequest;
use App\Http\Resources\Orgs\TodoResource;
use App\Models\Organization;
use App\Models\TodoCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org): AnonymousResourceCollection
    {
        return TodoResource::collection($org->todoCards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $org, TodoCard $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoUpdateRequest $request, Organization $org, TodoCard $todo): JsonResponse
    {
        // TODO: check owner is a member of the organization
        // TODO: check logged in user is an admin of the organization

        tap($todo)->update($request->validated());
        return response()->json(['message' => 'Todo updated successfully']);
    }

    public function owner(TodoUpdateOwnerRequest $request, Organization $org, TodoCard $todo): JsonResponse
    {
        // TODO: check owner is a member of the organization
        // TODO: check logged in user is an admin of the organization

        tap($todo)->update($request->validated());
        return response()->json(['message' => 'Todo owner updated successfully']);
    }

    public function supplier(TodoUpdateSupplierRequest $request, Organization $org, TodoCard $todo): JsonResponse
    {
        // TODO: check owner is a member of the organization
        // TODO: check logged in user is an admin of the organization

        tap($todo->item)->update($request->validated());
        return response()->json(['message' => 'Todo supplier updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoCard $todoCard)
    {
        //
    }
}
