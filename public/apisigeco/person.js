const aplicacion = document.querySelector('.container')
const getUrl = new URLSearchParams(window.location.search)
id = getUrl.get('id')

//const url = 'https://sisrec.gobernaciondecochabamba.bo/api/clntes'
const url = 'http://localhost/sisreca/public/api/clntes'

console.log(`${url}/${id}`)
fetch(`${url}/${id}`)
.then(res => res.json())
.then(data => {
    const ci = document.createElement('p')
    ci.innerHTML = data.ci
    const nombres = document.createElement('p')
    nombres.innerHTML = data.nombres
    const paterno = document.createElement('p')
    paterno.innerHTML = data.paterno
    const materno = document.createElement('p')
    materno.innerHTML = data.materno
    const celular = document.createElement('p')
    celular.innerHTML = data.celular
    const domicilio = document.createElement('p')
    domicilio.innerHTML = data.domicilio
    const cargo = document.createElement('p')
    cargo.innerHTML = data.cargo
    const dependencia = document.createElement('p')
    dependencia.innerHTML = data.dependencia
    aplicacion.appendChild(ci)
    aplicacion.appendChild(nombres)
    aplicacion.appendChild(paterno)
    aplicacion.appendChild(materno)
    aplicacion.appendChild(celular)
    aplicacion.appendChild(domicilio)
    aplicacion.appendChild(cargo)
    aplicacion.appendChild(dependencia)

})
.catch(err => console.log(err))
