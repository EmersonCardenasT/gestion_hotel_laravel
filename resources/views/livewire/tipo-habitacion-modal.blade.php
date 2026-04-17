<div>

    <x-button wire:click="crear">
        Nuevo Tipo Habitación
    </x-button>

    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            {{ $modo === 'crear' ? 'Nuevo Tipo Habitación' : 'Editar Tipo Habitación' }}
        </x-slot>

        <x-slot name="content">

            <div class="space-y-4">

                {{-- Nombre --}}
                <div>
                    <x-label value="Nombre" />
                    <x-input
                        type="text"
                        class="w-full mt-1"
                        wire:model="nombre"
                        placeholder="Ej: Suite Junior"
                    />
                    @error('nombre') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <x-label value="Descripción" />
                    <textarea
                        wire:model="descripcion"
                        rows="3"
                        placeholder="Describe brevemente este tipo de habitación..."
                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm resize-none"
                    ></textarea>
                    @error('descripcion') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Capacidad y Precio Base --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label value="Capacidad (personas)" />
                        <x-input
                            type="number"
                            class="w-full mt-1"
                            wire:model="capacidad"
                            placeholder="2"
                            min="1"
                        />
                        @error('capacidad') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-label value="Precio Base ($)" />
                        <x-input
                            type="number"
                            step="0.01"
                            class="w-full mt-1"
                            wire:model="precio_base"
                            placeholder="100.00"
                            min="0"
                        />
                        @error('precio_base') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Comodidades --}}
                <div>
                    <x-label value="Comodidades" />
                    <textarea
                        wire:model="comodidades"
                        rows="2"
                        placeholder="TV, Wifi, Aire acondicionado, Jacuzzi..."
                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm resize-none"
                    ></textarea>
                    @error('comodidades') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Activo --}}
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            wire:model="activo"
                            class="sr-only peer"
                        >
                        <div class="w-10 h-5 bg-gray-200 rounded-full peer
                                    peer-checked:bg-indigo-600
                                    after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                    after:bg-white after:rounded-full after:h-4 after:w-4
                                    after:transition-all peer-checked:after:translate-x-5">
                        </div>
                    </label>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Tipo activo</p>
                        <p class="text-xs text-gray-400">Si está activo, podrá asignarse a habitaciones</p>
                    </div>
                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <x-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-secondary-button>

            <x-button class="ml-2" wire:click="guardar">
                {{ $modo === 'crear' ? 'Crear Tipo' : 'Actualizar' }}
            </x-button>

        </x-slot>

    </x-dialog-modal>

</div>