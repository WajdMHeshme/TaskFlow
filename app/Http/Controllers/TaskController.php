<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function addTaskToFavorites($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoriteTasks()->syncWithoutDetaching($taskId);

        return response()->json(
            [
                "message" => "Task added to favorites"
            ],
            201
        );
    }

    public function deleteTaskFromFavorites($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoriteTasks()->detach($taskId);
        return response()->json([
            "message" => "Task removed from favorite list successfuly"
        ]);
    }


    public function getFavoriteTasks()
    {
        $favoriteTasks = Auth::user()->favoriteTasks();
        return response()->json([
            "favorite tasks" => $favoriteTasks
        ]);
    }



    public function getAllTasks()
    {
        $tasks = Task::all();
        return response()->json([
            "tasks" => $tasks
        ]);
    }

    public function getTasksByPriority()
    {
        $tasks = Auth::user()
            ->tasks()
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();

        return response()->json([
            "tasks" => $tasks
        ]);
    }


    public function index()
    {
        $user_tasks = Auth::user()->tasks;
        return response()->json($user_tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $task = Task::create($validatedData);
        return response()->json($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = Task::findOrFail($id);
        $user_id = Auth::user()->id;
        if ($user_id !== $task->user_id) {
            return response()->json([
                "message" => "unauthorized",
            ], 403);
        }
        $task->update($request->validated());
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(string $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($user_id !== $task->user_id) {
            return response()->json([
                "message" => "unauthorized",
            ], 403);
        }
        $task->delete();
        return response()->json(null, 204);
    }

    public function getUserTasks($id)
    {
        $tasks = User::find($id)->tasks;
        return response()->json($tasks);
    }

    public function addCategoriesToTask(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->categories()->attach($request->category_id);
        return response()->json('Categories added successfuly');
    }
}
