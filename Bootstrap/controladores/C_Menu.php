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
                if($id > 0) {
                    $respuesta['msj'] = 'Creado correctamente';
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