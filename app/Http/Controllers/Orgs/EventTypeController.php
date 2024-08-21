<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\EventTypes\EventTypeStoreRequest;
use App\Http\Requests\Orgs\EventTypes\EventTypeUpdateRequest;
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
    public function show(Organization $org, EventType $event_type) : EventTypeResource
    {
        return new EventTypeResource($event_type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventTypeUpdateRequest $request, Organization $org, EventType $event_type): EventTypeResource
    {
        $event_type->update([
            'name' => $request->name,
        ]);

        $event_type->items()->sync($request->items);

        return new EventTypeResource($event_type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $org, EventType $event_type)
    {
        $event_type->delete();
    }
}
