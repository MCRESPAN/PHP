
<?php
require_once 'modelos/Modelo.php';
require_once 'modelos/DAO.php';

class M_Menu extends Modelo {
    public $DAO;

    public function __construct() {
        parent::__construct();
        $this->DAO = new DAO();
    }

    public function obtenerMenuItems() {
        $SQL = "SELECT * FROM menu_items ORDER BY nivel, orden";
        return $this->DAO->consultar($SQL);
    }

    public function buscarMenuItems($filtros = array()) {
        $ftexto = '';
        $nivel = '';
        $padre_id = '';
        $es_dropdown = '';
        $orden = '';
        $id = '';
        extract($filtros);
    
        $SQL = 'SELECT * FROM menu_items WHERE 1=1 ';
    
        // Búsqueda por texto en múltiples campos
        if ($ftexto != '') {
            $aPalabras = explode(' ', $ftexto); // Divide en palabras el texto introducido por el usuario
            $SQL .= ' AND ( 1=2 ';
            foreach ($aPalabras as $palabra) {
                $SQL .= ' OR titulo LIKE "%' . $palabra . '%" 
                          OR controlador LIKE "%' . $palabra . '%" 
                          OR metodo LIKE "%' . $palabra . '%" 
                          OR url LIKE "%' . $palabra . '%" '; 
            }
            $SQL .= ')';
        }
    
        // Filtro por nivel
        if ($nivel != '') {
            $SQL .= ' AND nivel = ' . (int)$nivel . ' ';
        }
    
        // Filtro por padre_id
        if ($padre_id != '') {
            $SQL .= ' AND padre_id = ' . (int)$padre_id . ' ';
        }
    
        // Filtro por es_dropdown
        if ($es_dropdown != '') {
            $SQL .= ' AND es_dropdown = ' . (int)$es_dropdown . ' ';
        }
    
        // Filtro por orden
        if ($orden != '') {
            $SQL .= ' AND orden = ' . (int)$orden . ' ';
        }
    
        // Filtro por ID
        if ($id != '') {
            $SQL .= ' AND id = ' . (int)$id . ' ';
        }
    
        // Ordenar los resultados por nivel y orden
        $SQL .= ' ORDER BY nivel, orden ';
    
        return $this->DAO->consultar($SQL); // Devuelve los elementos del menú desde la base de datos
    }


    // Método para crear o actualizar un ítem del menú
    public function insertarMenuItem($datos = array()) {
        // Valores predeterminados
        $id = '';
        $titulo = '';
        $url = '';
        $nivel = 1;
        $padre_id = '';
        $orden = 1;
        $es_dropdown = 0;
        $controladorMenuItem = '';
        $metodoMenuItem = '';
        extract($datos);
    
        if (!empty($id)) {
            // Construcción limpia de la consulta UPDATE
            $SQL = "UPDATE menu_items SET 
                        `titulo` = '$titulo', 
                        `url` = " . (!empty($url) ? "'$url'" : "NULL") . ", 
                        `nivel` = $nivel, 
                        `padre_id` = " . ($padre_id !== '' ? $padre_id : "NULL") . ", 
                        `orden` = $orden, 
                        `es_dropdown` = $es_dropdown, 
                        `controlador` = " . (!empty($controladorMenuItem) ? "'$controladorMenuItem'" : "NULL") . ", 
                        `metodo` = " . (!empty($metodoMenuItem) ? "'$metodoMenuItem'" : "NULL") . " 
                    WHERE `id` = $id";
    
            error_log("Consulta UPDATE: $SQL"); // Log para depuración
            return $this->DAO->actualizar($SQL);
        } else {
            // Construcción limpia de la consulta INSERT
            $SQL = "INSERT INTO menu_items (
                        `titulo`, `url`, `nivel`, `padre_id`, `orden`, `es_dropdown`, `controlador`, `metodo`
                    ) VALUES (
                        '$titulo', 
                        " . (!empty($url) ? "'$url'" : "NULL") . ", 
                        $nivel, 
                        " . ($padre_id !== '' ? $padre_id : "NULL") . ", 
                        $orden, 
                        $es_dropdown, 
                        " . (!empty($controladorMenuItem) ? "'$controladorMenuItem'" : "NULL") . ", 
                        " . (!empty($metodoMenuItem) ? "'$metodoMenuItem'" : "NULL") . "
                    )";
    
            error_log("Consulta INSERT: $SQL"); // Log para depuración
            return $this->DAO->insertar($SQL);
        }
    }

    // Metodo para actualizar el orden de los items del menú tras crear un nuevo item
    public function actualizarOrdenMenuItems($datos) {

        // Construir la consulta SQL para actualizar el orden
        $padre_id = $datos['padre_id'];
        $orden = $datos['orden'];
    
        $SQL = "UPDATE menu_items
                SET orden = orden + 1
                WHERE " . (is_null($padre_id) || $padre_id === '' ? "padre_id IS NULL" : "padre_id = '$padre_id'") . "
                AND orden >= $orden";
    
        // Usar el método actualizar del DAO
        return $this->DAO->actualizar($SQL);
    
        // Verificar si se afectaron filas
        if ($resultado > 0) {
            return true;
        } else {
            // Manejar el caso en el que no se afecta ninguna fila
            error_log("No se afectaron filas en actualizarOrdenMenuItems: $SQL");
            return false;
        }
    }
    
    

}
?>