<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Create Task</h1>
        <form action="{{ route('task.store', $workspace) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <x-input-label>Title <span class="text-red-600">*</span></x-input-label>
                <x-text-input name="title" class="mt-1 block w-full" />
            </div>
            <div>
                <x-input-label>Description (optional)</x-input-label>
                <x-text-input name="description" class="mt-1 block w-full" />
            </div>
            <div>
                <x-input-label>Deadline <span class="text-red-600">*</span> </x-input-label>
                <x-text-input id="deadline" name="deadline" type="datetime-local" class="mt-1 block w-full"
                    min="{{ now()->format('Y-m-d\TH:i') }}" required />
            </div>
            <x-primary-button>Submit</x-primary-button>
        </form>
    </div>
</x-app-layout>
