<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-white text-xl">Logs</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <div class="bg-white shadow rounded overflow-hidden">

            <table class="w-full text-sm table-auto">

                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="p-2 text-center">ID</th>
                    <th class="p-2 text-center">Date</th>
                    <th class="p-2 text-left">Domain</th>
                    <th class="p-2 text-center">Result</th>
                    <th class="p-2 text-center">Code</th>
                    <th class="p-2 text-center">Time(ms)</th>
                    <th class="p-2 text-left">Error</th>
                    <th class="p-2 text-right">Actions</th>
                </tr>
                </thead>

                <tbody class="divide-y text-gray-700">

                @foreach($logs as $log)

                    <tr class="hover:bg-gray-50 transition align-middle">

                        <td class="p-2 text-center">
                            {{ $log->id }}
                        </td>

                        {{-- DATE --}}
                        <td class="p-2 text-center text-xs text-gray-500">
                            {{ $log->created_at?->format('Y-m-d H:i') }}
                        </td>

                        {{-- DOMAIN --}}
                        <td class="p-2 text-left font-medium text-gray-900">
                            {{ $log->domain->domain }}
                        </td>

                        {{-- RESULT --}}
                        <td class="p-2 text-center">
                            @if($log->response_result)
                                <span class="px-2 py-1 text-xs rounded text-green-600">
                                    UP
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded text-red-600">
                                    DOWN
                                </span>
                            @endif
                        </td>

                        {{-- CODE --}}
                        <td class="p-2 text-center">
                            {{ $log->response_code ?? '-' }}
                        </td>

                        {{-- TIME --}}
                        <td class="p-2 text-center">
                            {{ $log->response_time ?? '-' }}
                        </td>

                        {{-- ERROR --}}
                        <td class="p-2 text-left text-xs text-red-500 max-w-xs truncate">
                            {{ $log->response_error ?? '-' }}
                        </td>

                        {{-- ACTIONS --}}
                        <td class="p-2 text-right whitespace-nowrap">

                            <form method="POST"
                                  action="{{ route('logs.destroy', $log) }}"
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

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="mt-6 p-2 bg-green-100 text-green-600 rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>
</x-app-layout>
