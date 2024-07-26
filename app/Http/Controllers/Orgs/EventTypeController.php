<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\EventTypes\EventTypeStoreRequest;
use App\Http\Resources\Orgs\EventTypeResource;
use App\Models\EventType;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org): AnonymousResourceCollection
    {
        $eventTypes = $org->eventTypes;
        return EventTypeResource::collection($eventTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventTypeStoreRequest $request, Organization $org): EventTypeResource
    {
        /** @var EventType $eventType */
        $eventType = $org->eventTypes()->create([
            'name' => $request->name,
        ]);

        $eventType->items()->attach($request->items);

        return new EventTypeResource($eventType);
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
