<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">

        <h1 class="text-xl mb-4">Edit Domain</h1>

        <form method="POST" action="{{ route('domains.update', $domain) }}">
            @csrf
            @method('PUT')

            <input type="text"
                   name="domain"
                   value="{{ $domain->domain }}"
                   class="w-full border p-2 mb-3">
            @error('domain')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <input type="text"
                   name="title"
                   value="{{ $domain->title }}"
                   class="w-full border p-2 mb-3">

            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </form>

    </div>
</x-app-layout>
