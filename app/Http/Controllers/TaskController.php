<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $categories = auth()->user()->categories()->get();

        $query = auth()->user()->tasks()->with('category')->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $tasks = $query->get();
        $currentCategory = $request->category;

        return view('tasks.index', compact('tasks', 'categories', 'currentCategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->merge([
            'category_id' => $request->category_id ?: null
        ]);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
}
