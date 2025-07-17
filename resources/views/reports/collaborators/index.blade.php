<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Relatório de Colaboradores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Secção de Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Filtros</h3>
                    <form action="{{ route('reports.collaborators') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Filtro Grupo Econômico -->
                            <div>
                                <label for="economic_group_id" class="block text-sm font-medium">Grupo Econômico</label>
                                <select name="economic_group_id" id="economic_group_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Todos</option>
                                    @foreach($economicGroups as $group)
                                        <option value="{{ $group->id }}" {{ request('economic_group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro Bandeira -->
                            <div>
                                <label for="flag_id" class="block text-sm font-medium">Bandeira</label>
                                <select name="flag_id" id="flag_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Todas</option>
                                    @foreach($flags as $flag)
                                        <option value="{{ $flag->id }}" {{ request('flag_id') == $flag->id ? 'selected' : '' }}>
                                            {{ $flag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro Unidade -->
                            <div>
                                <label for="unit_id" class="block text-sm font-medium">Unidade</label>
                                <select name="unit_id" id="unit_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="">Todas</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->trading_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center space-x-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filtrar
                            </button>
                            <a href="{{ route('reports.collaborators') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                                Limpar Filtros
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Secção de Resultados -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Colaborador</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">E-mail</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unidade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bandeira</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Grupo</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($collaborators as $collaborator)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $collaborator->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $collaborator->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $collaborator->unit->trading_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $collaborator->unit->flag->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $collaborator->unit->flag->economicGroup->name }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Nenhum colaborador encontrado com os filtros aplicados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $collaborators->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
