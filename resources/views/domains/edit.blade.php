<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white shadow rounded-xl p-6">

                <h1 class="text-2xl font-semibold mb-6">
                    Edit Domain
                </h1>

                <form method="POST" action="{{ route('domains.update', $domain) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Domain --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Domain
                        </label>

                        <input type="text"
                               name="domain"
                               value="{{ old('domain', $domain->domain) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('domain')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title (optional)
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title', $domain->title) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Check Method --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Check Method
                        </label>

                        <select name="check_method"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                            <option value="HEAD"
                                {{ old('check_method', $domain->check_method) === 'HEAD' ? 'selected' : '' }}>
                                HEAD (fast)
                            </option>

                            <option value="GET"
                                {{ old('check_method', $domain->check_method) === 'GET' ? 'selected' : '' }}>
                                GET (full request)
                            </option>
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
                                   value="{{ old('timeout', $domain->timeout) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Interval --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Check Interval
                            </label>

                            <select name="check_interval"
                                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                                @foreach([1,5,15,30,60] as $interval)
                                    <option value="{{ $interval }}"
                                        {{ old('check_interval', $domain->check_interval) == $interval ? 'selected' : '' }}>
                                        {{ $interval }} min
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-600 font-medium px-6 py-2.5 rounded-lg transition">
                            Update Domain
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
