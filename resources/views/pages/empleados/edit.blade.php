<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Empleados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Editar Empleado {{ $empleado->nombre }} {{ $empleado->apellido }}
                </h1>

                <form id="formEditarEmpleado" action="{{ route('empleados.update', $empleado->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" id="nombre" required value="{{ $empleado->nombre }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                            focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                            <input type="text" name="apellido" id="apellido" required
                                value="{{ $empleado->apellido }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                            focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                            <input type="text" name="dni" id="dni" required value="{{ $empleado->dni }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                            focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ $empleado->email }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                            focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de
                                Ingreso</label>
                            <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                                value="{{ $empleado->fecha_ingreso }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                            focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Telefono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ $empleado->telefono }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                                                    focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Direccion</label>
                            <input type="text" name="direccion" id="direccion" value="{{ $empleado->direccion }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                            focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                    </div>


                    <button type="submit"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 
                        text-white text-sm font-medium rounded-lg shadow 
                        transition duration-150 ease-in-out">
                        Editar Empleado
                    </button>

                </form>

                <script>
                    document.getElementById('formEditarEmpleado').addEventListener('submit', function(e) {
                        e.preventDefault();

                        let formData = new FormData(this);

                        fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                Swal.fire({
                                    icon: data.success ? 'success' : 'error',
                                    title: data.success ? 'Éxito' : 'Error',
                                    text: data.message
                                });
                            });
                    });
                </script>

            </div>
        </div>
    </div>

</x-app-layout>
