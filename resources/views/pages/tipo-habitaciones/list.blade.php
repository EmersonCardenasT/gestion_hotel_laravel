<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tipos de Habitaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (session('success'))
                    <div
                        class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Tipos de Habitaciones</h2>
                        <p class="mt-1 text-sm text-slate-500">Administra tus tipos de habitación y sus tarifas.</p>
                    </div>
                </div>

                
                
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">

                    @foreach ($tipo_habitaciones as $tipo)
                        <div id="tipo-{{ $tipo->id_tipo }}"
                            class="group flex flex-col rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200">

                            {{-- ── CARD HEADER ── --}}
                            <div
                                class="flex items-center justify-between px-5 py-4 bg-slate-50 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-100">
                                        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 21V10.75m0 0V5.625c0-.621.504-1.125 1.125-1.125H15.75c.621 0 1.125.504 1.125 1.125v5.125" />
                                        </svg>
                                    </div>
                                    {{-- 👇 data-card-nombre aquí --}}
                                    <h3 data-card-nombre class="text-sm font-semibold text-slate-800">
                                        {{ $tipo->nombre }}</h3>
                                </div>

                                {{-- 👇 data-card-precio aquí --}}
                                <span data-card-precio
                                    class="inline-flex items-center rounded-lg bg-emerald-50 border border-emerald-200 px-2.5 py-1 text-sm font-semibold text-emerald-700">
                                    S/. {{ number_format($tipo->precio_base, 2) }}
                                </span>
                            </div>

                            {{-- ── CARD BODY ── --}}
                            <div class="flex flex-col flex-1 px-5 py-4 gap-4">

                                {{-- 👇 data-card-descripcion aquí --}}
                                <p data-card-descripcion class="text-sm text-slate-500 leading-relaxed line-clamp-2">
                                    {{ $tipo->descripcion ?: 'Sin descripción registrada.' }}
                                </p>

                                {{-- 👇 data-card-comodidades aquí --}}
                                <p data-card-comodidades class="text-sm text-slate-600 leading-relaxed line-clamp-2">
                                    {{ $tipo->comodidades ?: 'Sin comodidades registradas.' }}
                                </p>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2.5">
                                        <p class="text-xs text-slate-400 mb-1">Capacidad</p>
                                        {{-- 👇 data-card-capacidad aquí --}}
                                        <p data-card-capacidad class="text-sm font-semibold text-slate-800">
                                            {{ $tipo->capacidad }} personas
                                        </p>
                                    </div>
                                    <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2.5">
                                        <p class="text-xs text-slate-400 mb-1">Estado</p>
                                        <div class="flex items-center gap-1.5">
                                            <span
                                                class="h-2 w-2 rounded-full {{ $tipo->activo ? 'bg-emerald-500' : 'bg-rose-400' }}"></span>
                                            {{-- 👇 data-card-estado aquí --}}
                                            <p data-card-estado
                                                class="text-sm font-semibold {{ $tipo->activo ? 'text-emerald-700' : 'text-rose-600' }}">
                                                {{ $tipo->activo ? 'Activo' : 'Inactivo' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ── CARD FOOTER ── --}}
                            <div
                                class="flex items-center justify-between gap-2 px-5 py-3 border-t border-slate-100 bg-slate-50/60">

                                {{-- 👇 data-edit-btn y todos los data-* aquí en el botón Editar --}}
                                <button type="button" data-edit-btn onclick="openEditModal({{ $tipo->id_tipo }})"
                                    data-nombre="{{ e($tipo->nombre) }}"
                                    data-descripcion="{{ e($tipo->descripcion) }}"
                                    data-comodidades="{{ e($tipo->comodidades) }}"
                                    data-capacidad="{{ $tipo->capacidad }}"
                                    data-precio-base="{{ $tipo->precio_base }}"
                                    data-activo="{{ $tipo->activo ? '1' : '0' }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 hover:border-slate-300 transition">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    </svg>
                                    Editar
                                </button>

                                <form method="POST" action="{{ route('tipos-habitacion.destroy', $tipo->id_tipo) }}"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este tipo de habitación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-rose-600 bg-white border border-rose-200 rounded-lg hover:bg-rose-50 hover:border-rose-300 transition">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>

</x-app-layout>
