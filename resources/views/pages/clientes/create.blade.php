<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes / Huéspedes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- ENCABEZADO --}}
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Huéspedes</h1>
                        <p class="text-sm text-gray-500 mt-1">Registro y gestión de huéspedes</p>
                    </div>
                </div>

                <livewire:clientes.create-cliente />

            </div>
        </div>
    </div>
</x-app-layout>