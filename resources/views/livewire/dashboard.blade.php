<div>
    <div x-data="dashboardApp()" x-init="init()">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard — Gestión Hotelera
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ now()->format('l, d \d\e F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    Sistema activo
                </span>
                <span class="text-sm text-gray-500" x-text="currentTime"></span>
            </div>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">
                {{-- Widgets de Habitaciones --}}
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
                    
                    {{-- Total Habitaciones --}}
                    <div class="bg-indigo-50 rounded-2xl shadow-sm border border-indigo-100 p-6 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 rounded-xl">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $habitacionesStats['total'] }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Disponibles --}}
                    <div class="bg-green-50 rounded-2xl shadow-sm border border-green-100 p-6 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-green-50 rounded-xl">
                                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Disponibles</p>
                                <h3 class="text-2xl font-bold text-green-600">{{ $habitacionesStats['disponible'] }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Ocupadas --}}
                    <div class="bg-blue-50 rounded-2xl shadow-sm border border-blue-100 p-6 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-50 rounded-xl">
                                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Ocupadas</p>
                                <h3 class="text-2xl font-bold text-blue-600">{{ $habitacionesStats['ocupada'] }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- En Limpieza --}}
                    <div class="bg-yellow-50 rounded-2xl shadow-sm border border-yellow-100 p-6 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-yellow-50 rounded-xl">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.823.362l-1.17.976a1 1 0 00.35 1.726l7.482 2.494a2 2 0 001.216 0l7.482-2.494a1 1 0 00.35-1.726l-1.17-.976z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">En Limpieza</p>
                                <h3 class="text-2xl font-bold text-yellow-600">{{ $habitacionesStats['limpieza'] }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Mantenimiento --}}
                    <div class="bg-red-50 rounded-2xl shadow-sm border border-red-100 p-6 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-red-50 rounded-xl">
                                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Mantenimiento</p>
                                <h3 class="text-2xl font-bold text-red-600">{{ $habitacionesStats['mantenimiento'] }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Clientes --}}
                    <div class="bg-green-50 rounded-2xl shadow-sm border border-green-100 p-6 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-green-50 rounded-xl">
                                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Clientes</p>
                                <h3 class="text-2xl font-bold text-blue-600">{{ $habitacionesStats['cliente'] }}</h3>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Otros indicadores --}}
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8"> 

                    {{-- Ocupación --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <p class="text-gray-500 text-sm font-medium mb-1">Ocupación Actual</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-3xl font-bold text-gray-800">{{ $ocupacionPorcentaje }}%</h3>
                            <p class="text-xs text-gray-400 mb-1.5">de capacidad</p>
                        </div>
                        <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $ocupacionPorcentaje }}%"></div>
                        </div>
                    </div>

                    {{-- Reservas Pendientes --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <p class="text-gray-500 text-sm font-medium mb-1">Reservas Pendientes</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $reservasPendientes }}</h3>
                        <p class="mt-1 text-xs text-amber-600 font-medium">Por confirmar</p>
                    </div>

                    {{-- Estancias Activas --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <p class="text-gray-500 text-sm font-medium mb-1">Estancias Activas</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $estanciasActivas }}</h3>
                        <p class="mt-1 text-xs text-green-600 font-medium">Huéspedes en casa</p>
                    </div>
                </div>

            </div>
        </div>
    </div> 
 
</div>
