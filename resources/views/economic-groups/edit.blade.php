<x-app-layout>
    <x-slot name="header">
        {{-- Alteração 1: Título da página --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Grupo Econômico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Alteração 2: A rota do formulário agora aponta para 'update' e passa o ID do grupo --}}
                    <form action="{{ route('economic-groups.update', $economicGroup) }}" method="POST">
                        @csrf
                        {{-- Alteração 3: Formulários de edição em HTML usam o método PUT ou PATCH. O Laravel simula isso. --}}
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome</label>

                            {{-- Alteração 4: O valor do campo é preenchido com o dado atual do banco ($economicGroup->name). Se houver um erro de validação, ele usa o valor antigo que o usuário digitou (old('name')). --}}
                            <input type="text" name="name" id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600" value="{{ old('name', $economicGroup->name) }}" required autofocus>

                            @error('name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('economic-groups.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline mr-4">
                                Cancelar
                            </a>
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
