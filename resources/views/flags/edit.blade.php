<x-app-layout>
    <x-slot name="header">
        {{-- Alteração 1: Título da página --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Bandeira') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Alteração 2: A rota do formulário aponta para 'update' --}}
                    <form action="{{ route('flags.update', $flag) }}" method="POST">
                        @csrf
                        {{-- Alteração 3: Adiciona o método HTTP PUT --}}
                        @method('PUT')

                        <!-- Campo Nome -->
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome da Bandeira</label>
                            {{-- Alteração 5: Preenche o valor com o dado existente --}}
                            <input type="text" name="name" id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600" value="{{ old('name', $flag->name) }}" required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo de Seleção (Dropdown) -->
                        <div class="mt-4">
                            <label for="economic_group_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Grupo Econômico</label>
                            <select name="economic_group_id" id="economic_group_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                                <option value="">Selecione um grupo</option>
                                @foreach($economicGroups as $group)
                                    {{-- Alteração 4: Lógica para pré-selecionar o grupo correto --}}
                                    <option value="{{ $group->id }}" {{ old('economic_group_id', $flag->economic_group_id) == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('economic_group_id')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('flags.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline mr-4">Cancelar</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
