<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        return view('task.index');
    }

    // show individual task
    public function show(Workspace $workspace, Task $task) {
        if ($workspace->user_id !== auth()->id()) {
            abort(403);
        }

        $task->deadline_human = $task->deadline ? Carbon::parse($task->deadline)->diffForHumans() : null;
        $task->completed_at = $task->completed_at ? Carbon::parse($task->completed_at)->diffForHumans() : null;
        return view('task.show', compact('workspace', 'task'));
    }

    public function create(Workspace $workspace) {
    if ($workspace->user_id !== auth()->id()) {
        abort(403);
    }
        return view('task.create', compact('workspace'));
    }

    public function store(Request $request, Workspace $workspace) {
    if ($workspace->user_id !== auth()->id()) {
        abort(403);
    }
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'deadline' => 'required|after_or_equal:now'
        ]);

        $validated['user_id'] = auth()->id();

        $workspace->tasks()->create($validated);

        return redirect()->route('workspace.show', $workspace)->with('success', 'Task created successfully.');
    }

    // mark task as complete
    public function update(Request $request, Workspace $workspace, Task $task) {
        if ($workspace->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'is_completed' => 'required|boolean'
        ]);

        $task->is_completed = $validated['is_completed'];

        if ($validated['is_completed']) {
            if (!$task->completed_at) {
                $task->completed_at = Carbon::now();
            }
        } else {
            $task->completed_at = null;
        }

        $task->save();

        return redirect()
            ->route('workspace.show', $workspace)
            ->with('success', 'Task updated successfully.');
    }
}
