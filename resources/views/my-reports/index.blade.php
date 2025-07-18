    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Meus Relatórios') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @if(session('success'))
                            <div class="bg-green-500 text-white p-4 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Data da Solicitação</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($reports as $report)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($report->status == 'completed') bg-green-100 text-green-800 @endif
                                                @if($report->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                                @if($report->status == 'failed') bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($report->status == 'completed')
                                                <a href="{{ route('my-reports.download', $report) }}" class="text-indigo-600 hover:text-indigo-900">Download</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">Nenhum relatório solicitado.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $reports->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    