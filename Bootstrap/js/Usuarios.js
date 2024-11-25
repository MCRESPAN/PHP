function guardarUsuario() {

    // Validación de los campos antes de enviar los datos
    let nombre = document.getElementById('nombre').value;
    let login = document.getElementById('login').value;
    let email = document.getElementById('mail').value;
    let errores = [];

    if (!nombre) {
        errores.push("El campo nombre es obligatorio.");
    } else if (nombre.length < 3) {
        errores.push("El nombre debe tener al menos 3 caracteres.");
    }

    if (!login) {
        errores.push("El campo login es obligatorio.");
    } else if (login.length < 3) {
        errores.push("El login debe tener al menos 3 caracteres.");
    }

    if (!email) {
        errores.push("El campo email es obligatorio.");
    } else if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
        errores.push("El formato del email es incorrecto.");
    }

    if (errores.length > 0) {
        document.getElementById('msjError').innerHTML = errores.join("<br>");
        return; // Detenemos la ejecución de guardarUsuario si hay errores
    }

    // Si no hay errores, limpiamos el mensaje de error y procedemos con la llamada al servidor
    document.getElementById('msjError').innerHTML = "";

    console.log("Guardando usuario...");

    // Parámetros y opciones para el fetch
    let parametros = "controlador=Usuarios&metodo=guardarUsuario";
    let opciones = {method: 'GET',}
    parametros += "&" + new URLSearchParams(new FormData(document.getElementById('formularioUsuario'))).toString(); // Obtenemos los datos del formulario

    // Llamamos al servidor
    fetch("C_Frontal.php?" + parametros, opciones)
        .then(res => {
            if (res.ok) {                
                return res.json();       
            } 
            throw new Error(res.status); // Si no, capturamos el error
        })
        .then(resultado=> {
            if(resultado.correcto == 'S') {
                document.getElementById('capaEditarCrear').innerHTML = resultado.msj;
            } else {
                document.getElementById('msjError').innerHTML = resultado.msj;
            }
        })
        .catch(err => {                // Si hay un error lo mostramos 
            console.error("Error al guardar", err.message);
        });
}


function toggleEstadoUsuario(id_Usuario, isChecked) {
    const nuevoEstado = isChecked ? "S" : "N";

    let parametros = `controlador=Usuarios&metodo=cambiarEstado&id_Usuario=${id_Usuario}&nuevoEstado=${nuevoEstado}`;
    let opciones = {method: 'GET'}


    // Enviar el cambio de estado al servidor usando AJAX
    fetch("C_Frontal.php?" + parametros, opciones)
        .then(res => {
            if (res.ok) {                
                return res.json();       
            } 
            throw new Error(res.status); // Si no, capturamos el error
        })
        .then(resultado => {
            if (resultado.correcto === 'S') {
                // Actualizar el estilo en la interfaz de usuario
                const fila = document.querySelector(`#fila_${id_Usuario}`);
                const celdas = fila.querySelectorAll("td");

                // Cambiar el color de cada celda en la fila según el estado
                if (nuevoEstado === "S") {
                    celdas.forEach(celda => {
                        celda.style.color = "black"; // Cambia el estilo a 'Activo'
                    });
                    fila.querySelector(".estado-usuario").textContent = "";
                } else {
                    celdas.forEach(celda => {
                        celda.style.color = "red"; // Cambia el estilo a 'Inactivo'
                    });
                    fila.querySelector(".estado-usuario").textContent = "Inactivo";
                }
            } else {
                document.getElementById('msjError').innerHTML = resultado.msj;
            }
        })
        .catch(err => {                // Si hay un error lo mostramos 
            console.error("Error al guardar", err.message);
        });
}
