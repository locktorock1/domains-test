<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">

        <h1 class="text-xl mb-4">Create Domain</h1>

        <form method="POST" action="{{ route('domains.store') }}">
            @csrf
            <input type="text"
                   name="domain"
                   placeholder="example.com"
                   class="w-full border p-2 mb-3">
            @error('domain')
            <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <input type="text"
                   name="title"
                   placeholder="Title (optional)"
                   class="w-full border p-2 mb-3">

            <button class="px-4 py-2 bg-green-600 text-white rounded">
                Save
            </button>
        </form>

    </div>
</x-app-layout>
