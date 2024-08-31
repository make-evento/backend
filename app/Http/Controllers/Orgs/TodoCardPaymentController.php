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
    public function store(TodoPaymentStoreRequest $request, Organization $org, TodoCard $todo)
    {
        $files = [];

        foreach ($request->file('attachments') as $file) {
            $files[] = $file->store('attachments', 'r2');
        }
        $request_validated = $request->validated();
        $request_validated['installment'] = count($request->installments);

        $request_validated['first_payment_at'] = $this->firstPayment($request->installments);
        $request_validated['amount'] = $this->amount($request->installments);

        $payment = $todo->payments()->create([
            ...$request_validated,
            'attachments' => $files,
        ]);

        TodoPaymentCreated::dispatch($payment, $request->installments);

        return new TodoPaymentResource($payment);
    }

    public function firstPayment($installments){
        $first_payment = '';
        foreach($installments as $installment) {
            if($first_payment == '') {
                $first_payment = $installment['due_date'];
            }else{
                $first_payment = $first_payment < $installment['due_date'] ? $first_payment : $installment['due_date'];
            }
        }

        return $first_payment;
    }

    public function amount($installments){
        $amount = 0;
        foreach($installments as $installment) {
            $amount += $installment['amount'];
        }

        return $amount;
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
