<x-app-layout>
    <div class="bg-white max-w-5xl mx-auto p-6 mt-8 space-y-2">
        <p class="font-bold">{{ $task->title }}</p>
        <div class="text-sm w-fit">
            @if ($task->is_completed)
                <p class="bg-green-200 px-4 rounded-full text-green-800">Completed at {{$task->completed_at}}</p>
            @else
                <p class="bg-red-200 px-4 rounded-full text-red-800">Not Completed</p>
            @endif
        </div>
        <p class="">{{ $task->description }}</p>
        <p class="text-sm text-gray-500">Due: {{ $task->deadline_human }}</p>
        <form action="{{ route('task.update', ['workspace' => $workspace->id, 'task' => $task->id]) }}"
            method="POST" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <input type="hidden" name="is_completed" value="0">
            <input type="checkbox" name="is_completed" value="1" onchange="this.form.submit()"
                {{ $task->is_completed ? 'checked' : '' }}>
            <span class="text-sm">Mark as completed</span>
        </form>
    </div>
</x-app-layout>
