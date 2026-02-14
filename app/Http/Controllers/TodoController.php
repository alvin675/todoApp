<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    // Create a Instance
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'status_id' => 'required|exists:statuses,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        $todo = Todo::create($data); // Using a SQL to create data

        return response()->json([
            'message' => 'Successfully Created TODO List',
            'data' => $todo
        ], 201);
    }

    // Get Single Value
    public function show($id) {
        $todo = Todo::with([
            'category',
            'priority',
            'status'
        ])->find($id);

        if(!$todo) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        return response()->json($todo);
    }

    // Get All Data
    public function index() {
        $todos = Todo::with([
            'category',
            'priority',
            'status'
        ])->get();

        return response()->json($todos);
    }

    // Update
    public function update(Request $request, $id) {
        $todo = Todo::find($id);

        if(!$todo) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'priority_id' => 'sometimes|exists:priorities,id',
            'status_id' => 'sometimes|exists:statuses,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        $todo->update($validated);

        return response()->json([
            'message' => 'List Updated',
            'data' => $todo
        ]);
    }

    // Delete
    public function destroy($id) {
        $todo = Todo::find($id);

        if(!$todo) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $todo->delete();

        return response()->json([
            'message' => 'Deleted Successfully'
        ]);
    }
}
