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
    parametros += "&" + new URLSearchParams(new FormData(document.getElementById('formularioMenuItem'))).toString();

    // Llamamos al servidor
    fetch("C_Frontal.php?" + parametros, opciones)
        .then(res => {
            if (res.ok) {
                return res.json();
            }
            throw new Error(res.status); // Si no, capturamos el error
        })
        .then(resultado => {
            if (resultado.correcto === 'S') {
                // Mostrar mensaje de éxito
                document.getElementById('msjError').innerHTML = resultado.msj;

                // Cerrar el formulario flotante
                document.querySelector('.formulario-superpuesto').remove();

                // Si se ha creado un nuevo elemento, agregarlo dinámicamente a la tabla
                if (resultado.menu_item) {
                    agregarFilaATabla(resultado.menu_item);
                }
            } else {
                // Mostrar mensaje de error
                document.getElementById('msjError').innerHTML = resultado.msj;
            }
        })
        .catch(err => { // Si hay un error lo mostramos 
            console.error("Error al guardar", err.message);
        });
}


function agregarFilaATabla(item) {
    let referenciaFila;

    if (item.previo_id) {
        // Encuentra la fila del elemento previo al nuevo
        referenciaFila = document.getElementById(`menu_item_${item.previo_id}`);
    }

    let nuevaFila = document.createElement('tr');
    nuevaFila.setAttribute('id', `menu_item_${item.id}`);
    
    // Aplica el estilo directamente
    nuevaFila.style.color = '#006400'; // Verde oscuro
    nuevaFila.style.fontWeight = 'bold'; // Negrita opcional
    
    nuevaFila.innerHTML = `
        <td></td>
        <td>
            <img src="img/edit.png" style="height:1.2em;" 
                onclick="obtenerVista_EditarCrear_Menu('Menu', 'getVistaEditar', 'menu_item_${item.id}_edit', '${item.id}');">
        </td>
        <td>${item.padre_padre_id ? '&nbsp;&nbsp;&nbsp;&nbsp;' : ''}${item.titulo}</td>
        <td></td>
        <td>${item.controlador || '-'}</td>
        <td>${item.metodo || '-'}</td>
        <td>
            <button class="btn btn-sm btn-primary" 
                onclick="obtenerVista_EditarCrear_Menu(\'Menu\', \'getVistaCrear\', 'menu_item_${item.id}_edit', '${item.id}');">
                Añadir debajo
            </button>
          </td>
    `;

    let tablaBody = document.querySelector('table tbody'); // Asegúrate de que el tbody existe

    if (referenciaFila) {
        // Insertar justo después de la fila previa
        referenciaFila.parentNode.insertBefore(nuevaFila, referenciaFila.nextSibling);
    } else if (tablaBody) {
        // Si no hay referencia, añadir en la segunda posición de la tabla
        let primeraFila = tablaBody.firstChild;
        if (primeraFila) {
            tablaBody.insertBefore(nuevaFila, primeraFila.nextSibling);
        } else {
            // Si no hay filas, añadir como la primera
            tablaBody.appendChild(nuevaFila);
        }
    } else {
        console.error('No se encontró el cuerpo de la tabla.');
    }
}




function obtenerVista_EditarCrear_Menu(controlador, metodo, destino, id) {

    let parametros = "controlador=" + controlador + "&metodo=" + metodo + "&id=" + id
    let opciones = {method: 'GET',}

    // Elimina formularios existentes si están abiertos
    let formularioExistente = document.querySelector('.formulario-superpuesto');
    if (formularioExistente) {
        formularioExistente.remove();
    }

    // Obtén la fila correspondiente
    let fila = document.getElementById(`menu_item_${id}`);
    if (!fila) return;

    // Crea un contenedor flotante para el formulario
    let contenedorFormulario = document.createElement('div');
    contenedorFormulario.classList.add('formulario-superpuesto');
    contenedorFormulario.setAttribute('id', destino);

    // Establece la posición del formulario justo debajo de la fila
    let rectFila = fila.getBoundingClientRect();
    let anchoFormulario = 1000; // Ancho en píxeles del formulario (más estrecho)
    contenedorFormulario.style.position = 'absolute';
    contenedorFormulario.style.top = `${rectFila.bottom + window.scrollY}px`;
    contenedorFormulario.style.left = `${rectFila.left + (rectFila.width / 2) - (anchoFormulario / 2) + window.scrollX}px`;
    contenedorFormulario.style.width = `${anchoFormulario}px`;

    // Añade el contenedor al body para que esté independiente de la tabla
    document.body.appendChild(contenedorFormulario);

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


function cerrarEdicion(destino) {
    let contenedorEdicion = document.getElementById(destino);
    if (contenedorEdicion) {
        contenedorEdicion.remove();
    }
}
