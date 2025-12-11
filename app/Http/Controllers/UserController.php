<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getTasksUser($id)
    {
        $user = Task::find($id)->user;
        return response()->json($user);
    }
    public function getAuthUser()
    {
        $user_id = Auth::user()->id;
        $user = User::with('profile')->findOrFail($user_id);
        return new UserResource($user);
    }
}
