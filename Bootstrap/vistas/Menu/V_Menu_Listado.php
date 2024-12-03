<?php
$menuItems = array(); // Inicializamos el array vacío
extract($datos); // Extraemos los datos pasados a la vista

// Función recursiva para construir la tabla
function construirMenuRecursivo($items, $padre_id = null, $nivel = 0) {
    $html = '';
    global $ultimoMenuItemId;
    foreach ($items as $item) {
        if ($item['padre_id'] === $padre_id) {
            $indentacion = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $nivel); // Indentación para los subniveles
            $html .= '<tr id="menu_item_' . $item['id'] . '">';
             $html .= '<td></td>';
            // Ícono de edición
            $html .= '<td><img src="img/edit.png" style="height:1.2em;" onclick="obtenerVista_EditarCrear_Menu(\'Menu\', \'getVistaEditar\', 
                            \'menu_item_' . $item['id'] . '_edit\', \'' . $item['id'] . '\');"></td>';
            $html .= '<td>' . $indentacion . htmlspecialchars($item['titulo']) . '</td>';
            // $html .= '<td>' . htmlspecialchars($item['id']) . '</td>';
            // $html .= '<td>' . htmlspecialchars($item['nivel']) . '</td>';
            // $html .= '<td>' . ($padre_id === null ? 'Raíz' : htmlspecialchars($padre_id)) . '</td>';
            $html .= '<td>' . ($item['es_dropdown'] ? 'Sí' : '') . '</td>';
            // $html .= '<td>' . htmlspecialchars($item['orden']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['controlador'] ?: '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item['metodo'] ?: '-') . '</td>';
            // Botón de añadir debajo
            $html .= '<td>
                            <button class="btn btn-sm btn-primary" onclick="obtenerVista_EditarCrear_Menu(\'Menu\', \'getVistaCrear\', 
                            \'menu_item_' . $item['id'] . '_add\', \'' . $item['id'] . '\');">
                                Añadir debajo
                            </button>
                      </td>';
            $html .= '</tr>';

            // Llama recursivamente para los hijos
            $html .= construirMenuRecursivo($items, $item['id'], $nivel + 1);
        }
    }
    return $html;
}

// Renderizar la tabla completa
$html = '<div class="table-responsive mt-3 w-100">';
$html .= '<table class="table table-sm table-striped w-100">';
$html .= '<thead><tr>
             <th style="width: 15%;"></th>
             <th style="width: 10%;"></th> <!-- Columna para el ícono de edición -->
             <th style="width: 15%;">Título</th>
             <!-- <th>ID</th> --> <!-- Ocultado -->
             <!-- <th>Nivel</th> --> <!-- Ocultado -->
             <!-- <th>Padre</th> --> <!-- Ocultado -->
             <th style="width: 10%;">Dropdown</th>
             <!-- <th>Orden</th> --> <!-- Ocultado -->
             <th style="width: 15%;">Controlador</th>
             <th style="width: 15%;">Método</th>
             <th style="width: 20%;"></th> <!-- Columna para los botones de añadir -->
          </tr></thead>';
$html .= '<tbody>';

// Botón para añadir al principio del menú
$html .= '<tr id="menu_item_0">'; // ID especial para "al principio"
$html .= '<td></td>';
$html .= '<td></td>'; // Columna vacía para ícono de edición
$html .= '<td></td>'; // Columna vacía para el título
$html .= '<td></td>'; // Columna vacía para Dropdown
$html .= '<td></td>'; // Columna vacía para Controlador
$html .= '<td></td>'; // Columna vacía para Método
$html .= '<td>
             <button class="btn btn-sm btn-success" onclick="obtenerVista_EditarCrear_Menu(\'Menu\', \'getVistaCrear\', 
             \'menu_item_0_add\', \'0\');">
                 Añadir al principio
             </button>
         </td>';
$html .= '</tr>';


// Generar las filas del menú de forma recursiva
$html .= construirMenuRecursivo($menuItems);

$html .= '</tbody>';
$html .= '</table></div>';

// Añadimos la capa para la edición de un menú_item
$html .= '<div class="container-fluid" id="capaEditarCrear"></div>';

echo $html; // Mostramos la tabla
?>
