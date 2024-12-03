<?php


require_once 'controladores/Controlador.php';  // Como un import, para que pueda hacer el extends y heredar
require_once 'Modelos/M_Usuarios.php';
require_once 'vistas/Vista.php';

class C_Usuarios extends Controlador{
    private $modelo;

    // Constructor
    public function __construct() {
        parent::__construct(); // Llamamos al constructor de la clase padre Controlador
        $this->modelo = new M_Usuarios(); // Llamamos al modelo de la clase M_Usuarios 
    }

    public function validarUsuario($datos = array()){
        $id_Usuario = $this->modelo->login($datos);
        return $id_Usuario;
    }

    // Metodos
    public function getVistaFiltros($datos=array()){  // Si no le llega nada, creará la variable datos como un array vacío 
        Vista::render('vistas/Usuarios/V_Usuarios_Filtros.php'); // Llamamos al método render que hemos creado en la clase Vista 
    }

    public function getVistaNuevoEditar($datos=array()){  
        if(!isset($datos['id']) || $datos['id']=='') {
            // nuevo
            Vista::render('vistas/Usuarios/V_Usuarios_NuevoEditar.php');     
        } else{
            // editar
            $filtros['id_Usuario'] = $datos['id'];
            $usuarios = $this->modelo->buscarUsuarios($filtros);
            Vista::render('vistas/Usuarios/V_Usuarios_NuevoEditar.php', array('usuario' => $usuarios[0]));     
        }  
    }

    public function getVistaListadoUsuarios($filtros=array()){     // Si no le llega nada, creará la variable filtros como un array vacío
        // var_dump($filtros);                                    // Un echo para arrays
        $usuarios = $this->modelo->buscarUsuarios($filtros);      // Llamamos al metodo buscarUsuarios del modelo
        Vista::render('vistas/Usuarios/V_Usuarios_Listado.php', array('usuarios' => $usuarios));  // Llamamos al método render que hemos creado en la clase Vista 
    }

    public function guardarUsuario($datos=array()){        // Si no le llega nada, creará la variable datos como un array vacío
        $respuesta['correcto'] = 'S';    
        $respuesta['msj'] = 'Creado correctamente';

        // Verificar si el login existe 
        $usuarioExiste = $this->modelo->buscarUsuarios(['login' => $datos['login']]);

        if(!empty($usuarioExiste)) {
            $respuesta['correcto'] = 'N';
            $respuesta['msj'] = 'El Nombre de Usuario (Login) ya existe';
        }else{
            $id = $this->modelo->insertarUsuario($datos);      
            if($id > 0) {
                if (!empty($datos['id_Usuario'])) { // Si ha sido exitoso y hay id_Usuario (si hay es por que se ha editado en vez de creado), cambiamos el mensaje a Editado correctamente
                    $respuesta['msj'] = 'Editado correctamente';
                }
            } else {
                $respuesta['correcto'] = 'N';   
                $respuesta['msj'] = 'Se ha producido un error';
            } 
        }
        echo json_encode($respuesta);
    }

    public function cambiarEstado($datos=array()) {
        $respuesta['correcto'] = 'S';    
        $respuesta['msj'] = 'Estado actualizado correctamente';

        // Verificar si el login existe 
        $resultado = $this->modelo->actualizarEstadoUsuario($datos['id_Usuario'], $datos['nuevoEstado']);
        if(!$resultado){
            $respuesta['correcto'] = 'N';    
        $respuesta['msj'] = 'Estado actualizado incorrectamente';
        }
        
        echo json_encode($respuesta);
    }


    
    
}
?>
