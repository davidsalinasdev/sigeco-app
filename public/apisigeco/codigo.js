let form = document.getElementById('form')

form.addEventListener('submit', (e) => {
    e.preventDefault()

    let login = document.getElementById('login').value
    let password = document.getElementById('password').value
    
    console.log(JSON.stringify({ login, password }));

    let token = "servidoresgadc123456"
    
    //let Authorization = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI0NzQyNDUzMyIsIm5hbWUiOiJKb2huIERvZSIsImlhdCI6MTUxNjIzOTAyMn0.ooZunm86I_WXNXPBovWEIa2FtVD0536lyEk8uwSgRp4"
    //let Content-Type = "application/json"
    //let x-cpt-authorization = "eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJBR0VUSUMiLCJpYXQiOjE2NDM5ODEzNDksImlkVXN1YXJpb0FwbGljYWNpb24iOjExNiwiaWRUcmFtaXRlIjoiMTE2NyJ9.snvgxugazFwyB4g1Y6W8HULDGRxsmWH2DrvsZTPT_Xs"

    const aplicacion = document.querySelector('.container')

    const url = 'http://correspondencia.gobernaciondecochabamba.bo/Restserver/singin'
    //const url = 'http://localhost/sisreca/public/api/clntes/'
    //const url = '{{route("clntes.autenticar")}}'
    //const url = 'https://<url-base-servicio-ppe>/transaccion/deuda'

    fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            login,
            password,
            token:token   //token asignado para consumir API del otro extremo
        }),
        headers: {
            //"Authorization" : "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI0NzQyNDUzMyIsIm5hbWUiOiJKb2huIERvZSIsImlhdCI6MTUxNjIzOTAyMn0.ooZunm86I_WXNXPBovWEIa2FtVD0536lyEk8uwSgRp4",
            "Content-Type": "application/json; charset=UTF-8",
            //"x-cpt-authorization" : "eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJBR0VUSUMiLCJpYXQiOjE2NDM5ODEzNDksImlkVXN1YXJpb0FwbGljYWNpb24iOjExNiwiaWRUcmFtaXRlIjoiMTE2NyJ9.snvgxugazFwyB4g1Y6W8HULDGRxsmWH2DrvsZTPT_Xs"
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
    
        // Accede a los datos específicos que deseas pintar
        const usuario = data.data[0];
    
        // Crear elementos HTML y añadirlos al DOM
        const container = document.querySelector('.container');
    
        // const pIdServidor = document.createElement('p');
        // pIdServidor.textContent = `ID del servidor: ${usuario.idServidor}`;
        // container.appendChild(pIdServidor);
    
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

        // Repite el proceso para otros datos que desees mostrar
    
    })
    .catch(error => {
        console.error('Error en la solicitud fetch:', error);
    });

    // //OTRA FORMA 1
    // .then(response => response.text())
    // .then(data => {
    //     console.log(data);
    // })
    // .catch(error => {
    //     console.error('Error en la solicitud fetch:', error);
    // });
    
    // //OTRA FORMA 2
    // .then(response => response.json())
    // .then(data => console.log(data))
    // .catch(error => console.error('Error:', error));

    // //OTRA FORMA 3
    // .then(response => {
    //     console.log(response);
    //     if (!response.ok) {
    //         throw new Error(`Error de red: ${response.status}`);
    //     }
    //     return response.json();
    // })
    // .then((data) => {
    //     console.log(data);
    //     data.forEach(dcliente => {
    //         console.log(dcliente.nombres);
    //         const p = document.createElement('p');
    //         p.innerHTML = dcliente.nombres;
    //         aplicacion.appendChild(p);
    //     });
    // })

    // //OTRA FORMA 4
    // .then((data) => {
    //     console.log(data);
    //     if (Array.isArray(data) && data.length > 0) {
    //         data.forEach(dcliente => {
    //             console.log(dcliente.nombres);
    //             const p = document.createElement('p');
    //             p.innerHTML = dcliente.nombres;
    //             aplicacion.appendChild(p);
    //         });
    //     } else {
    //         console.log('La respuesta no es un array válido o está vacía.');
    //     }
    // })

    
})
