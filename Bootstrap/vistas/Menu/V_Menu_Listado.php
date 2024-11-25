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
            $html .= '<tr>';
            // Ícono de edición
            $html .= '<td><img src="img/edit.png" style="height:1.2em;" onclick="obtenerVista_EditarCrear(\'Menu\', \'getVistaEditar\', 
                    \'capaEditarCrear\', \''.$item['id'].'\');"></td>';
            $html .= '<td>' . $indentacion . htmlspecialchars($item['titulo']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['nivel']) . '</td>';
            $html .= '<td>' . ($padre_id === null ? 'Raíz' : htmlspecialchars($padre_id)) . '</td>';
            $html .= '<td>' . ($item['es_dropdown'] ? 'Sí' : 'No') . '</td>';
            $html .= '<td>' . htmlspecialchars($item['orden']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['controlador'] ?: '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item['metodo'] ?: '-') . '</td>';
            // Botón de añadir debajo
            $html .= '<td><button class="btn btn-sm btn-primary" onclick="obtenerVista_EditarCrear(\'Menu\', \'getVistaCrear\', 
                                                                            \'capaEditarCrear\', \''.$item['id'].'\');">
                                                                            Añadir debajo
                                                                        </button></td>';
            $html .= '</tr>';

            // Llama recursivamente para los hijos
            $html .= construirMenuRecursivo($items, $item['id'], $nivel + 1);
        }
    }
    return $html;
}

// Renderizar la tabla completa
$html = '<div class="table-responsive mt-3">';
$html .= '<table class="table table-sm table-striped">';
$html .= '<thead><tr>
             <th></th> <!-- Columna para el ícono de edición -->
             <th>Título</th>
             <th>ID</th>
             <th>Nivel</th>
             <th>Padre</th>
             <th>Dropdown</th>
             <th>Orden</th>
             <th>Controlador</th>
             <th>Método</th>
             <th></th> <!-- Columna para los botones de añadir -->
          </tr></thead>';
$html .= '<tbody>';

// Botón para añadir al principio del menú
$html .= '<tr>';
$html .= '<td colspan="9"></td>';
$html .= '<td><button class="btn btn-sm btn-success" onclick="obtenerVista_EditarCrear(\'Menu\', \'getVistaCrear\', \'capaEditarCrear\', \'0\');">
                                                                                                                            Añadir al principio </button></td>';
$html .= '</tr>';

// Generar las filas del menú de forma recursiva
$html .= construirMenuRecursivo($menuItems);

$html .= '</tbody>';
$html .= '</table></div>';

// Añadimos la capa para la edición de un menú_item
$html .= '<div class="container-fluid" id="capaEditarCrear"></div>';

echo $html; // Mostramos la tabla
?>
