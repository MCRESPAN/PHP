<?php


$usuarios = array(); // Lo definimos de primeras como array vacío
extract($datos);     // Extraemos los datos (es la propiedad que pasamos, mirar la clase Vista)

// Construimos la tabla donde se mostrarán los usuarios buscados
$html = '';
$html .= '<div class="table-responsive mt-3">
          <table class="table table-sm table-striped">';  // Usar una tabla de estilo bootstrap (lo metemos en un div con la clase de arriba para que se haga responsive)
$html .= '<thead> 
             <tr>
                <th></th>
                <th>Apellidos, nombre</th>
                <th>Mail</th>
                <th>Login</th>
                <th>Estado</th>
                <th></th>
             </tr>
          </thead>
          <tbody>';
$activo = '';          
foreach ($usuarios as $posicion => $fila) {
    $estilo = '';
    if($fila['activo'] == 'N') {  // Si es n, mostrará que está inactivo, si es s, no mostrará nada (para que se diferencien mejor los que estan inactivos)
        $activo = 'Inactivo';
        $estilo = 'color:red';
    } else {
        $activo = '';
    }

    // Switch de estado activo/inactivo
    $switchId = 'flexSwitchCheck' . $fila['id_Usuario'];
    $switchChecked = ($fila['activo'] == 'S') ? 'checked' : '';

    $html .= '<tr id="fila_'.$fila['id_Usuario'].'">
            <td><img src="img/edit.png" style="height:1.2em;"
                    onclick="obtenerVista_EditarCrear(\'Usuarios\', \'getVistaNuevoEditar\', 
                    \'capaEditarCrear\', \''.$fila['id_Usuario'].'\');"></td>
            <td nowrap style="'.$estilo.'">'.$fila['apellido_1'].' '.$fila['apellido_2'].', '.$fila['nombre'].'</td>
            <td style="'.$estilo.'">'.$fila['mail'].'</td>
            <td style="'.$estilo.'">'.$fila['login'].'</td>
            <td class="estado-usuario" style="'.$estilo.'">'.$activo.'</td>    
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="'.$switchId.'" '.$switchChecked.'
                           onclick="toggleEstadoUsuario('.$fila['id_Usuario'].', this.checked)">
                    <label class="form-check-label" for="'.$switchId.'"></label>
                </div>
            </td>
         </tr>'; 
}
$html .= '</tbody>
        </table>
        </div>';

echo $html; // Mostramos la tabla

?>