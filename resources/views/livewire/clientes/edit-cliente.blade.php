<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">
    
                {{-- ENCABEZADO --}}
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Huéspedes</h1>
                        <p class="text-sm text-gray-500 mt-1">Actualizacion Datos del Cliente  <strong style="color: red">{{$cliente->nombres}} {{$cliente->apellidos}}</strong></p>
                    </div>
                </div>


{{-- Notificación flash --}}
    @if (session()->has('mensaje'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-lg">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('mensaje') }}
        </div>
    @endif
    <form wire:submit.prevent="actualizar" class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm font-medium">Nombres *</label>
                <input placeholder="Ingrese su nombre" type="text" wire:model="nombres"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
                @error('nombres') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-sm font-medium">Apellidos *</label>
                <input placeholder="Ingrese su nombre" type="text" wire:model="apellidos"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
                @error('apellidos') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-sm font-medium">Tipo Documento</label>
                <select wire:model="tipo_documento"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
                    <option value="">Seleccione</option>
                    <option>DNI</option>
                    <option>Pasaporte</option>
                    <option>Carnet Extranjería</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-medium">Número Documento *</label>
                <input placeholder="12312344" type="text" wire:model="numero_documento"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
                @error('numero_documento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-sm font-medium">Teléfono</label>
                <input placeholder="987 564 321" type="text" wire:model="telefono"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="text-sm font-medium">Email</label>
                <input placeholder="Ej. correo@email.com" type="email" wire:model="email"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium">Dirección</label>
                <input placeholder="Ej. Av. 24 de Septiembre 1234, Pichanaki" type="text" wire:model="direccion"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="text-sm font-medium">País</label>
                <input placeholder="Perú" type="text" wire:model="pais"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 mt-1">
            </div>

        </div>

        <div class="flex justify-end gap-3">
            <a wire:navigate href="{{ route('clientes.index') }}"
                class="px-4 py-2 border border-gray-200 rounded-lg">
                Cancelar
            </a>

            <button type="submit"
                class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                Actualizar Cliente
            </button>
        </div>

    </form>

</div>