<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Domains</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <a href="{{ route('domains.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            + Add Domain
        </a>

        <div class="bg-white shadow rounded overflow-hidden">

            <table class="w-full text-sm table-auto">

                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="p-2 text-center">ID</th>
                    <th class="p-2 text-left">Domain</th>
                    <th class="p-2 text-left">Title</th>
                    <th class="p-2 text-center">Status</th>
                    <th class="p-2 text-center">Code</th>
                    <th class="p-2 text-center">Time (ms)</th>
                    <th class="p-2 text-center">Checked</th>
                    <th class="p-2 text-right">Actions</th>
                </tr>
                </thead>

                <tbody class="divide-y text-gray-700">

                @foreach($domains as $domain)

                    @php
                        $log = $domain->last_log;
                    @endphp

                    <tr class="hover:bg-gray-50 transition align-middle">

                        {{-- ID --}}
                        <td class="p-2 text-center text-gray-600">
                            {{ $domain->id }}
                        </td>

                        {{-- DOMAIN --}}
                        <td class="p-2 text-left font-medium text-gray-900">
                            {{ $domain->domain }}
                        </td>

                        {{-- TITLE --}}
                        <td class="p-2 text-left text-gray-600">
                            {{ $domain->title ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="p-2 text-center">
                            @if($log?->response_result)
                                <span class="px-2 py-1 rounded text-green-600">
                                    UP
                                </span>
                            @elseif($log)
                                <span class="px-2 py-1 rounded text-red-600">
                                    DOWN
                                </span>
                            @else
                                <span class="px-2 py-1 rounded text-gray-600">
                                    NO DATA
                                </span>
                            @endif
                        </td>

                        {{-- CODE --}}
                        <td class="p-2 text-center">
                            {{ $log?->response_code ?? '-' }}
                        </td>

                        {{-- TIME --}}
                        <td class="p-2 text-center">
                            {{ $log?->response_time ?? '-' }}
                        </td>

                        {{-- CHECKED AT --}}
                        <td class="p-2 text-center text-xs text-gray-500">
                            {{ $log?->created_at?->format('Y-m-d H:i') ?? '-' }}
                        </td>

                        {{-- ACTIONS --}}
                        <td class="p-2 text-right whitespace-nowrap space-x-3">

                            <a href="{{ route('domains.check', $domain) }}"
                               class="text-green-600 hover:underline">
                                Check
                            </a>

                            <a href="{{ route('domains.edit', $domain) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('domains.destroy', $domain) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 hover:underline"
                                        onclick="return confirm('Delete?')">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $domains->links() }}
        </div>

        @if (session('success'))
            <div class="mt-6 p-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>
</x-app-layout>
