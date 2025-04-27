<x-app-layout>
    <div class="bg-white rounded max-w-6xl mx-auto mt-6 px-6 py-4">
        <div class="flex items-center gap-2 text-sm pb-4 text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-arrow-left-icon lucide-arrow-left">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg><a href="{{ route('workspace.index') }}">Back to workspace</a></div>
        <h1 class="text-2xl font-semibold mb-2">Workspace: <span class="font-semibold">{{ $workspace->name }}</span>
        </h1>
        <div class="flex items-center justify-between pb-4">
            <h2 class="text-lg font-semibold mt-4 mb-2">Tasks</h2>
            <form action="{{ route('task.create', $workspace) }}" method="get">
                <x-primary-button>Add Task</x-primary-button>
            </form>
        </div>
        @if ($tasks->count() > 0)
            <div class="grid grid-cols-3 gap-4">
                @foreach ($tasks as $task)
                    <div class="px-6 py-3 border rounded-lg space-y-2">
                        <form action="{{ route('task.update', ['workspace' => $workspace->id, 'task' => $task->id]) }}"
                            method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_completed" value="0">
                            <input type="checkbox" name="is_completed" value="1" onchange="this.form.submit()"
                                {{ $task->is_completed ? 'checked' : '' }}>
                            <span class="text-sm">Mark as completed</span>
                        </form>
                        <div class="text-xl font-bold">{{ $task->title }}</div>
                        @if (!$task->is_completed)
                            <div class="text-gray-500 text-sm">{{ $task->deadline_human }}</div>
                        @else
                            <div class="text-gray-500 text-sm">{{ $task->completed_human }}</div>
                        @endif
                        <a href="{{ route('task.show', [$workspace, $task]) }}"
                            class="underline text-gray-500 text-sm">View</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-600 text-center">No tasks created</div>
        @endif

    </div>
</x-app-layout>
