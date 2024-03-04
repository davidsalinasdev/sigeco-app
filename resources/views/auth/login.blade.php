<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- <form id="form" method="POST" action="{{ route('login') }}">
    @csrf --}}

    <!-- Email Address -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Contraseña')" />

        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recuérdame') }}</span>
    </label>
    </div> --}}

    <div class="flex items-center justify-end mt-4">
        {{-- @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
        {{ __('Olvidaste tu contraseña?') }}
        </a>
        @endif --}}

        {{-- <x-primary-button class="ml-3">
                {{ __('Ingresar') }}
        </x-primary-button> --}}

        <x-secondary-button id="btnIngresar" type="button" class="ml-3">
            {{ __('Ingresar') }}
        </x-secondary-button>
    </div>

    {{-- </form> --}}

    <div class="container">
    </div>
    <div id="menError">
    </div>

</x-guest-layout>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        document.getElementById("btnIngresar").addEventListener("click", () => {

            console.log('hola');

            let login = document.getElementById('email').value
            let password = document.getElementById('password').value

            console.log(JSON.stringify({
                login,
                password
            }));

            let token = "servidoresgadc12345"

            const aplicacion = document.querySelector('.container')

            const url = 'http://correspondencia.gobernaciondecochabamba.bo/Restserver/singin'

            fetch(url, {
                    method: 'POST',
                    body: JSON.stringify({
                        login,
                        password,
                        token: token //token asignado para consumir API del otro extremo
                    }),
                    headers: {
                        "Content-Type": "application/json; charset=UTF-8",
                    },
                    //mode: 'cors',
                })

                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error de red: ${response.status}`);
                    }
                    return response.json();
                })

                .then(data => {
                    // Aquí data es el objeto JSON que recibiste
                    console.log(data);

                    if (data.status === "success") {

                        // Accede a los datos específicos que deseas pintar
                        const usuario = data.data[0];

                        // Crear elementos HTML y añadirlos al DOM
                        const container = document.querySelector('.container');

                        const pCi = document.createElement('p');
                        pCi.textContent = `CI: ${usuario.ci}`;
                        container.appendChild(pCi);

                        const pNombres = document.createElement('p');
                        pNombres.textContent = `Nombre Completo: ${usuario.nombres} ${usuario.paterno} ${usuario.materno}`;
                        container.appendChild(pNombres);

                        const pCargo = document.createElement('p');
                        pCargo.textContent = `Cargo: ${usuario.cargo}`;
                        container.appendChild(pCargo);

                        const pDependencia = document.createElement('p');
                        pDependencia.textContent = `Dependencia: ${usuario.dependencia}`;
                        container.appendChild(pDependencia);

                        const pSigla = document.createElement('p');
                        pSigla.textContent = `Sigla: ${usuario.sigla}`;
                        container.appendChild(pSigla);

                        //**************************
                        //enviamos los datos obtenidos al controlador mediante otro api
                        const newData = {
                            idUsuario: usuario.idUsuario,
                            email: usuario.usuario,
                            password: password,
                            ci: usuario.ci,
                            nombres: usuario.nombres,
                            paterno: usuario.paterno,
                            materno: usuario.materno,
                            celular: usuario.celular,
                            domicilio: usuario.domicilio,
                            estado: usuario.estado,
                            cargo: usuario.cargo,
                            dependencia: usuario.dependencia,
                            idServidor: usuario.idServidor,
                            sigla: usuario.sigla
                        };

                        const csrfToken = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('login') }}",
                            data: JSON.stringify(newData),
                            contentType: 'application/json; charset=UTF-8',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },

                            success: function(contData) {
                                console.log('Datos procesados en el controlador:', contData);

                                if (contData.redirect) {
                                    window.location.href = contData.redirect;
                                }

                            },
                            error: function(error) {
                                console.error('Error en la solicitud_a:', error.responseText);
                                mostrarError('Error en la solicitud_a: ' + error.responseText);
                            }
                        });
                        //**************************

                    } else {
                        // Mostrar mensaje de error
                        mostrarError('Error: ' + data.message);
                    }

                })
                .catch(error => {
                    console.error('Error en la solicitud_b:', error.message);
                    mostrarError('Error en la solicitud_b: ' + error.message);

                });

            function mostrarError(error) {

                // Actualizar el contenido del contenedor de mensajes de error
                document.getElementById('menError').innerHTML = `<p style="color: red;">${error}</p>`;
            }
        });
    })
</script>