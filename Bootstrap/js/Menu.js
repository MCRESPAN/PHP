function guardarMenuItem() {

    // Validación de los campos antes de enviar los datos
    let titulo = document.getElementById('titulo').value;
    let nivel = document.getElementById('nivel').value;
    let orden = document.getElementById('orden').value;
    let errores = [];

    if (!titulo) {
        errores.push("El campo título es obligatorio.");
    } else if (titulo.length < 3) {
        errores.push("El título debe tener al menos 3 caracteres.");
    }

    if (!nivel) {
        errores.push("El campo nivel es obligatorio.");
    } else if (isNaN(nivel) || nivel <= 0) {
        errores.push("El nivel debe ser un número mayor que 0.");
    }

    if (!orden) {
        errores.push("El campo orden es obligatorio.");
    } else if (isNaN(orden) || orden <= 0) {
        errores.push("El orden debe ser un número mayor que 0.");
    }

    if (errores.length > 0) {
        document.getElementById('msjError').innerHTML = errores.join("<br>");
        return; // Detenemos la ejecución de guardarMenuItem si hay errores
    }

    // Si no hay errores, limpiamos el mensaje de error y procedemos con la llamada al servidor
    document.getElementById('msjError').innerHTML = "";

    console.log("Guardando menú...");

    // Parámetros y opciones para el fetch
    let parametros = "controlador=Menu&metodo=guardarMenuItem";
    let opciones = { method: 'GET' };
    parametros += "&" + new URLSearchParams(new FormData(document.getElementById('formularioMenuItem'))).toString(); // Obtenemos los datos del formulario

    // Llamamos al servidor
    fetch("C_Frontal.php?" + parametros, opciones)
        .then(res => {
            if (res.ok) {
                return res.json();
            }
            throw new Error(res.status); // Si no, capturamos el error
        })
        .then(resultado => {
            if (resultado.correcto == 'S') {
                document.getElementById('capaEditarCrear').innerHTML = resultado.msj;
            } else {
                document.getElementById('msjError').innerHTML = resultado.msj;
            }
        })
        .catch(err => { // Si hay un error lo mostramos 
            console.error("Error al guardar", err.message);
        });
}
