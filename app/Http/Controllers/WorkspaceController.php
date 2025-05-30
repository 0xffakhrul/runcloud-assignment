<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function index() {
        $workspaces = auth()->user()->workspaces()->get();

        return view('workspace.index', compact('workspaces'));
    }

    // show the tasks within the workspace.
    // the flow should be workspace/{workspace}
    public function show(Workspace $workspace) {
        if ($workspace->user_id !== auth()->id()) {
            abort(403);
        }
            $tasks = $workspace->tasks()->get();

        foreach($tasks as $task) {
            // incomplete task
            if (!$task->is_completed) {
                if ($task->deadline) {
                    $now = Carbon::now();
                    $deadline = Carbon::parse($task->deadline);
                    $diff = $now->diff($deadline);
                    $parts = [];
                    if ($diff->d > 0) $parts[] = $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
                    if ($diff->h > 0) $parts[] = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
                    if ($diff->i > 0) $parts[] = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
                    $task->deadline_human = count($parts) ? 'Due in ' . implode(' ', $parts) : 'Due now';
                } else {
                    $task->deadline_human = null;
                }
            // completed task
            } else {
                if ($task->completed_at) {
                    $completedTime = Carbon::parse($task->completed_at);
                    $diffInMinutes = $completedTime->diffInMinutes(Carbon::now());
                    
                    // more readable
                    if ($diffInMinutes < 1) {
                        $task->completed_human = 'Marked as completed just now';
                    } else {
                        $task->completed_human = 'Marked as completed ' . $completedTime->diffForHumans();
                    }
                }
            }
        }

        return view('workspace.show', compact('workspace', 'tasks'));
    }

    public function create() {
        return view('workspace.create');
    }
    
    public function store (Request $request) {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);

        $validated['user_id'] = auth()->id();

        Workspace::create($validated);

        return redirect()->route('workspace.index')->with('success', 'workspace created successfully');
    }
}
