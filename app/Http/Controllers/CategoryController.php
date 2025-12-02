<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json([
            'message' => 'category created successfuly',
            'category' => $category
        ], 201);
    }

    public function getTaskCategories($taskID)
    {
        $categories = Task::find($taskID)->categories;
        return response()->json($categories);
    }

    public function getCategoriesTask($catID)
    {
        $tasks = Category::find($catID)->tasks;
        return response()->json($tasks);
    }
}
