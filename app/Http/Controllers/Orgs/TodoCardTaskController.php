<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orgs\Todo\Task\TodoTaskStoreRequest;
use App\Http\Requests\Orgs\Todo\Task\TodoTaskUpdateRequest;
use App\Models\Organization;
use App\Models\TodoCard;
use App\Models\TodoCardTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodoCardTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $org, TodoCard $todo): JsonResponse
    {
        $tasks = $todo->tasks;
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoTaskStoreRequest $request, Organization $org, TodoCard $todo): JsonResponse
    {
        $task = $todo->tasks()->create($request->validated());
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoTaskUpdateRequest $request, Organization $org, TodoCard $todo, TodoCardTask $task): JsonResponse
    {
        $task = tap($task)->update($request->validated());
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $org, TodoCard $todo, TodoCardTask $task): JsonResponse
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
