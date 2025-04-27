<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Create Workspace</h1>
        <form action="{{ route('workspace.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <x-input-label>Workspace Name</x-input-label>
                <x-text-input name="name" class="mt-1 block w-full" />
            </div>
            <x-primary-button>Create</x-primary-button>
        </form>
    </div>
</x-app-layout>
