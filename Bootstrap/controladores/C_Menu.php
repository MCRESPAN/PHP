<?php
require_once 'controladores/Controlador.php';
require_once 'modelos/M_Menu.php';
require_once 'vistas/Vista.php';

class C_Menu extends Controlador {
    private $modelo;

    public function __construct() {
        parent::__construct();
        $this->modelo = new M_Menu();
    }

    public function getVistaMenu() {
        $menuItems = $this->modelo->obtenerMenuItems();
        Vista::render('./vistas/Menu/V_Menu.php', array('menuItems' => $menuItems));
    }

    // Vista con el botón de Buscar
    public function getVistaMenuVertical() {
        Vista::render('./vistas/Menu/V_Menu_Filtros.php');
    }

    // Vista con los elementos del menú listados
    public function getMenuListado() {
        $menuItems = $this->modelo->obtenerMenuItems();
        Vista::render('./vistas/Menu/V_Menu_Listado.php', array('menuItems' => $menuItems));
    }

    // Vista para editar un item del menú
    public function getVistaEditar($datos=array()){  
        // editar
        $filtros['id'] = $datos['id'];
        $menuItems = $this->modelo->buscarMenuItems($filtros);
        Vista::render('vistas/Menu/V_Menu_NuevoEditar.php', array('menu_item' => $menuItems[0]));         
    }

    // Vista para crear un item del menú
    public function getVistaCrear($datos=array()){  
        //si datos['id'] es igual a 0
        if( $datos['id'] == 0 ) {
            // encontrar el id del item con el orden=1 y nivel=1
            $filtros['nivel'] = 1;
            $filtros['orden'] = 1;
            $menuItems = $this->modelo->buscarMenuItems($filtros);
            // cambiamos el orden de ese item a 0 y lo guardamos en $menuItems
            $menuItems[0]['orden'] = 0;
        } else{
            // sino busca por su id
            $filtros['id'] = $datos['id'];
            $menuItems = $this->modelo->buscarMenuItems($filtros);
        }
        Vista::render('vistas/Menu/V_Menu_Nuevo.php', array('menu_item' => $menuItems[0]));      

    }

    // Funcion para guardar/editar un item del menú
    public function guardarMenuItem($datos=array()){        // Si no le llega nada, creará la variable datos como un array vacío
        $respuesta['correcto'] = 'S';    
        $respuesta['msj'] = 'Creado correctamente';

            if (empty($datos['id'])) { // Si no hay un id, es un nuevo item
                // Llamar a una nueva funcion para aumentar el orden en +1 de los items que tengan el mismo padre que el nuevo item y su orden sea igual o mayor que el del nuevo item
                $this->modelo->actualizarOrdenMenuItems($datos);
                $id = $this->modelo->insertarMenuItem($datos);     
                if ($id > 0) {

                    // Verifica si no es necesario realizar la consulta
                    if (($datos['padre_id'] === null || $datos['padre_id'] == 0) && $datos['orden'] == 1) {
                        // Si padre_id es null o 0, y orden es 1, no se realiza la consulta
                        $previoId = null;
                        $padrePadreId = null;
                    } else {
                        // Construye los filtros para la consulta
                        $filtros = [
                            'padre_id' => $datos['padre_id'],
                            'orden' => $datos['orden'] - 1
                        ];

                        // Ejecuta la consulta para obtener el elemento previo
                        $elementoPrevio = $this->modelo->buscarMenuItems($filtros);

                        // Verifica si el resultado de la consulta contiene datos
                        if (!empty($elementoPrevio) && isset($elementoPrevio[0])) {
                            $previoId = $elementoPrevio[0]['id'];
                            $padrePadreId = $elementoPrevio[0]['padre_id'];
                        } else {
                            $previoId = null;
                            $padrePadreId = null;
                        }
                    }
                    

                    $respuesta['correcto'] = 'S';
                    $respuesta['msj'] = 'Creado correctamente';
                    $respuesta['menu_item'] = [
                        'id' => $id,
                        'titulo' => $datos['titulo'],
                        'nivel' => $datos['nivel'],
                        'padre_id' => $datos['padre_id'],
                        'orden' => $datos['orden'],
                        'controlador' => $datos['controladorMenuItem'],
                        'metodo' => $datos['metodoMenuItem'],
                        'previo_id' => $previoId,
                        'padre_padre_id' => $padrePadreId
                    ];
                } else {
                    $respuesta['correcto'] = 'N';   
                    $respuesta['msj'] = 'Se ha producido un error';
                }
            } else {
                $id = $this->modelo->insertarMenuItem($datos);     
                if($id > 0) {
                    $respuesta['msj'] = 'Editado correctamente';   
                } else {
                    $respuesta['correcto'] = 'N';   
                    $respuesta['msj'] = 'Se ha producido un error';
                } 
            }
        
        echo json_encode($respuesta);
    }
    
}
?>