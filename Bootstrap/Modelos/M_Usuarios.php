<?php


require_once 'Modelos/Modelo.php';
require_once 'Modelos/DAO.php';

class M_Usuarios extends Modelo {
   
    public $DAO;

    public function __construct() {
        parent::__construct();   // ejecutar el constructor del padre
        $this->DAO = new DAO();  // crear el objeto DAO 
    }


    public function login($datos=array()) {
        $usuario = 'ewgrtgt';
        $pass = 'vethryhy';
        extract($datos);

        $usuario = addcslashes($usuario, '/');

        $SQL = "SELECT * FROM usuarios WHERE login = '$usuario' AND pass = MD5('$pass')";

        $usuarios = $this->DAO->consultar($SQL);

        $id_Usuario = '';
        if(empty($usuarios)){
            // no encontrado
        } else {
            // encontrado
            $_SESSION['login'] = $usuario;
            $_SESSION['usuario'] = $usuarios[0]['nombre'];
            $_SESSION['id_Usuario'] = $usuarios[0]['id_Usuario'];
            $id_Usuario = $usuarios[0]['id_Usuario'];
        }
        return $id_Usuario;
    }
    


    public function buscarUsuarios($filtros=array()){
        $ftexto = '';
        $factivo = '';
        $id_Usuario = '';
        $login = '';
        extract($filtros);

        $SQL = 'SELECT * FROM usuarios WHERE 1=1 ';

        if($ftexto != '') {

            $aPalabras = explode(' ', $ftexto);  // Divide en palabras el texto introducido por el usuario cuando haya un espacio, ' '
            $SQL .= ' AND ( 1=2 ';
            foreach($aPalabras as $palabra) {
                $SQL .= ' OR nombre LIKE "%'.$palabra.'%" 
                          OR apellido_1 LIKE "%'.$palabra.'%" 
                          OR apellido_2 LIKE "%'.$palabra.'%"
                          OR mail LIKE "%'.$palabra.'%" 
                          OR login LIKE "%'.$palabra.'%" ';  // El .= es concatenar, como un +
                                                             // El % es que contenga ese texto
                                                             // Se hacen los OR para que lo que queramos buscar se encuentre en el nombre, en el primer apellido o en el segundo, o en el mail o en el login
            }
            $SQL .= ')';
        }

        if($factivo != '') {
            $SQL .= ' AND activo = "'.$factivo.'" ';
        }

        if($id_Usuario != '') {
            $SQL .= ' AND id_Usuario = "'.$id_Usuario.'" ';
        }

        if($login != ''){
            $SQL .= " AND login = '$login' ";
        }

        $SQL .= ' ORDER BY apellido_1, apellido_2, nombre, login '; // Ordenar alfabéticamente los usuarios
        
        return $this->DAO->consultar($SQL);   // Devuelve los usuarios desde base de datos
    }
    
    // Método para crear un nuevo usuario
    public function insertarUsuario($datos= array()){
        // Damos valores predeterminados a las variables
        $id_Usuario = '';
        $nombre = '';
        $apellido_1 = '';     
        $apellido_2 = '';
        $sexo = '';
        $fecha_alta = date('Y-m-d');
        $mail = '';
        $movil = '';
        $login = 'duiehdiew';
        $pass = 'euhuwejdod';
        $activo = 'S';
        extract($datos);

        $pass = md5($pass); // Encriptar contraseña
        
        // Condición para verificar si el usuario ya existe (id_Usuario)
        if (!empty($id_Usuario)) {
            // Actualizar la base de datos del usuario con el id_Usuario
            $SQL = "UPDATE usuarios SET 
                        nombre = '$nombre',
                        apellido_1 = '$apellido_1',
                        apellido_2 = '$apellido_2',
                        sexo = '$sexo',
                        fecha_alta = '$fecha_alta',
                        mail = '$mail',
                        movil = '$movil',
                        login = '$login',
                        pass = '$pass',
                        activo = '$activo'
                    WHERE id_Usuario = '$id_Usuario'";

            return $this->DAO->actualizar($SQL);
        } else {
            // Crear un nuevo usuario si no existe un id_Usuario
            $SQL = "INSERT INTO usuarios SET 
                        nombre = '$nombre',
                        apellido_1 = '$apellido_1',
                        apellido_2 = '$apellido_2',
                        sexo = '$sexo',
                        fecha_alta = '$fecha_alta',
                        mail = '$mail',
                        movil = '$movil',
                        login = '$login',
                        pass = '$pass',
                        activo = '$activo'";

            return $this->DAO->insertar($SQL);
        }
    }

    public function actualizarEstadoUsuario($id_Usuario, $nuevoEstado) {
        $SQL = "UPDATE usuarios SET activo = '$nuevoEstado' WHERE id_Usuario = '$id_Usuario'";
        return $this->DAO->actualizar($SQL);
    }
    

}

?>