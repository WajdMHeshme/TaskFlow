<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getTasksUser($id)
    {
        $user = Task::find($id)->user;
        return response()->json($user);
    }
}
