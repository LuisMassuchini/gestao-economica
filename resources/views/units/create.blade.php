<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Nova Unidade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Exibir erros de validação gerais --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('units.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Campo Nome Fantasia -->
                            <div>
                                <label for="trading_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome Fantasia</label>
                                <input type="text" name="trading_name" id="trading_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600" value="{{ old('trading_name') }}" required>
                            </div>

                            <!-- Campo Razão Social -->
                            <div>
                                <label for="company_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Razão Social</label>
                                <input type="text" name="company_name" id="company_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600" value="{{ old('company_name') }}" required>
                            </div>

                            <!-- Campo CNPJ -->
                            <div>
                                <label for="cnpj" class="block font-medium text-sm text-gray-700 dark:text-gray-300">CNPJ</label>
                                <input type="text" name="cnpj" id="cnpj" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600" value="{{ old('cnpj') }}" required>
                            </div>

                            <!-- Campo de Seleção para Bandeira -->
                            <div>
                                <label for="flag_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Bandeira</label>
                                <select name="flag_id" id="flag_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                                    <option value="">Selecione uma bandeira</option>
                                    @foreach($flags as $flag)
                                        <option value="{{ $flag->id }}" {{ old('flag_id') == $flag->id ? 'selected' : '' }}>
                                            {{ $flag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('units.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline mr-4">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
