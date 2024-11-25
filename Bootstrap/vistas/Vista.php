<?php
// El objetivo de las vistas es pintar algo, solamente
class Vista{
    static public function render($rutaVista, $datos=array()){  // Espero dos argumentos, pero si solo hay uno, crea una variable datos que contiene un array vacío
        require($rutaVista);                             // Esto hace que el archivo se cargue y se pinte
    }
}
?>