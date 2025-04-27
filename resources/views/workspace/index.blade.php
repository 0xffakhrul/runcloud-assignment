<x-app-layout>
    <div class="bg-white rounded max-w-6xl mx-auto mt-6 px-6 py-4">
        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold mb-4">Workspaces</h1>
            <form action="{{ route('workspace.create') }}" method="get">
                <x-primary-button>Add Workspace</x-primary-button>
        </div>
        </form>
        <div class="grid grid-cols-3 gap-4">
            @foreach ($workspaces as $workspace)
                <div class="px-6 py-3 border rounded-lg space-y-2">
                    <div class="text-xl font-bold">{{ $workspace->name }}</div>
                    <div class="text-gray-500 text-sm">Created at {{ $workspace->created_at }}</div>
                    <a href="{{ route('workspace.show', $workspace->id) }}"
                        class="underline text-gray-500 text-sm">View</a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
