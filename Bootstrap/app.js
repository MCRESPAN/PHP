function cargarUnScript(url) {  // Para cargar un script
    let script = document.createElement('script'); // Crea un elemento script
    script.src = url; // Asigna la url
    document.head.appendChild(script); // Inserta el script en el destino
}

function obtenerVista(controlador, metodo, destino) {

    let parametros = "controlador=" + controlador + "&metodo=" + metodo
    let opciones = {method: 'GET',}

    // Llamamos al servidor
    fetch("C_Frontal.php?" + parametros, opciones)
        .then(res => {
            if (res.ok) {                // Si puede responder
                return res.text();       // Devolvemos el texto
            } 
            throw new Error(res.status); // Si no, capturamos el error
        })
        .then(vista=> {
            document.getElementById(destino).innerHTML = vista; // Mostramos la vista, insertando el html en el destino
            cargarUnScript('js/' + controlador + '.js');
        })
        .catch(error => {                // Si hay un error lo mostramos 
            console.log("Error al pedir vista", error.message);
        });
}


function obtenerVista_EditarCrear(controlador, metodo, destino, id) {

    let parametros = "controlador=" + controlador + "&metodo=" + metodo + "&id=" + id
    let opciones = {method: 'GET',}

    // Llamamos al servidor
    fetch("C_Frontal.php?" + parametros, opciones)
        .then(res => {
            if (res.ok) {                // Si puede responder
                return res.text();       // Devolvemos el texto
            } 
            throw new Error(res.status); // Si no, capturamos el error
        })
        .then(vista=> {
            document.getElementById(destino).innerHTML = vista; // Mostramos la vista, insertando el html en el destino
        })
        .catch(error => {                // Si hay un error lo mostramos 
            console.log("Error al pedir vista", error.message);
        });
}


function buscar(controlador, metodo, formulario, destino) {

    let parametros = "controlador=" + controlador + "&metodo=" + metodo
    let opciones = {method: 'GET',}
    parametros += "&" + new URLSearchParams(new FormData(document.getElementById(formulario))).toString(); // Obtenemos los datos del formulario

    // Llamamos al servidor
    fetch("C_Frontal.php?" + parametros, opciones)
        .then(res => {
            if (res.ok) {                // Si puede responder
                return res.text();       // Devolvemos el texto
            } 
            throw new Error(res.status); // Si no, capturamos el error
        })
        .then(vista=> {
            document.getElementById(destino).innerHTML = vista; // Mostramos la vista, insertando el html en el destino
        })
        .catch(error => {                // Si hay un error lo mostramos 
            console.log("Error al pedir vista", err.message);
        });
}


