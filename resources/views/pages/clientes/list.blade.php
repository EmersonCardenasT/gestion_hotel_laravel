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
                    <a wire:navigate.hover href="{{ route('clientes.create') }}"
                       class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                        <span class="text-lg leading-none">+</span> Nuevo Huésped
                    </a>
                </div>

                <livewire:clientes.list-clientes />

            </div>

        </div>
    </div>
</x-app-layout>