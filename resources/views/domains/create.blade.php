<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white shadow rounded-xl p-6">

                <h1 class="text-2xl font-semibold mb-6">
                    Create Domain
                </h1>

                <form method="POST" action="{{ route('domains.store') }}" class="space-y-5">
                    @csrf

                    {{-- Domain --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Domain
                        </label>

                        <input type="text"
                               name="domain"
                               placeholder="example.com"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('domain')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title (optional)
                        </label>

                        <input type="text"
                               name="title"
                               placeholder="My Website"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    {{-- Method --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Check Method
                        </label>

                        <select name="check_method"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="HEAD">HEAD (fast)</option>
                            <option value="GET">GET (full request)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Timeout --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Timeout (sec)
                            </label>

                            <input type="number"
                                   name="timeout"
                                   min="1"
                                   max="60"
                                   value="5"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        {{-- Interval --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Check Interval
                            </label>

                            <select name="check_interval"
                                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1">1 min</option>
                                <option value="5">5 min</option>
                                <option value="15">15 min</option>
                                <option value="30">30 min</option>
                                <option value="60">1 hour</option>
                            </select>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-600 font-medium px-6 py-2.5 rounded-lg transition">
                            Save Domain
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
