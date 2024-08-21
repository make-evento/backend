<?php

namespace App\Http\Controllers\Orgs;

use App\Events\TodoPaymentCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Todo\Payment\TodoPaymentStoreRequest;
use App\Http\Resources\Orgs\TodoPaymentResource;
use App\Models\Organization;
use App\Models\TodoCard;
use Illuminate\Http\Request;

class TodoCardPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org, TodoCard $todo)
    {
        return TodoPaymentResource::collection($todo->payments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoPaymentStoreRequest $request, Organization $org, TodoCard $todo): TodoPaymentResource
    {
        $files = [];

        foreach ($request->file('attachments') as $file) {
            $files[] = $file->store('attachments', 'r2');
        }

        $payment = $todo->payments()->create([
            ...$request->validated(),
            'attachments' => $files,
        ]);

        TodoPaymentCreated::dispatch($payment);

        return new TodoPaymentResource($payment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
