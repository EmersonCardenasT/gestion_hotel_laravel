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
        
                <livewire:tipo-habitacion-list />

            </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('confirmarEliminar', (data) => {

                Swal.fire({
                    title: '¿Eliminar?',
                    text: 'No podrás revertir esto',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {

                    if (result.isConfirmed) {
                        Livewire.emit('eliminarTipo', data.id)
                    }

                })

            })

        })
</script>

</x-app-layout>
