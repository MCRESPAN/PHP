<?php

    $getPost = array_merge($_GET, $_POST, $_FILES); // Un array para regoger los $_GET, $_POST y $_FILES

    // TRATAR SEGÚN LOS PARÁMETROS QUE NOS PASEN
    if (isset($getPost['controlador']) && $getPost['controlador'] != '') { // Si existe la variable $getPost['controlador'] y no es igual a vacío   
        // recibido controlador
        $controlador = 'C_'.$getPost['controlador'];            // Cojo el nombre que me han pasado y le añado la C_
        if(file_exists('controladores/'.$controlador.'.php')) { // Si existe el archivo 
            // existe el controlador
            $metodo = $getPost['metodo'];                   // pongo el nombre del método
            require_once './controladores/'.$controlador.'.php';
            $objControlador = new $controlador();           // Instancia de un objeto del controlador que nos han pasado
            if(method_exists($objControlador, $metodo)) {   // Si existe el método
                // existe el metodo
                $objControlador -> $metodo($getPost);       // Llamamos al metodo
            } else {
                echo 'Error CF-03'; // No existe el metodo; está bien explicar al lado los errores que inventemos para que se entiendan en el momento
            }
        } else {
            echo 'Error CF-02'; // No existe el fichero de controlador
        }

    } else {
        // no recibido controlador
        echo 'Error CF-01';  // Es bueno crear nombres a los errores para identificarlos fácil cuando sucedan
    }    

    /* Forma NO estandarizada, válida solo para la clase C_Usuarios
    // C_Usuarios.php
    require_once './controladores/C_Usuarios.php'; // Un import
    $objControlador = new C_Usuarios();  // Instancia de un objeto de la clase C_Usuario
    $objControlador -> getPrueba();      // Llamamos al metodo
    */
?>