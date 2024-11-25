
<?php 
session_start(); 
if (!isset($_SESSION['login']) || $_SESSION['login'] === '') {
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Dependencias -->
        <link href="librerias/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="librerias/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
        <link href="css/app.css" rel="stylesheet">
    </head>
    <body>
        <!-- Container fluid es que va a ser una pantalla responsive que se va a adaptar a la pantalla del usuario -->
        <div class="container-fluid" id="capaEncabezado">
            <div class="row">
                
                <div class="col-md-2 col-sm-9 d-none d-sm-block">  <!-- así especificamos los tamaños en la pantalla, cuantas columnas ocupará; entre todos los elementos siempre tienen que sumar 12; funcionalidad exclusiva de bootstrap -->
                    <img src="img/mcf.png" style="height: 5rem;">
                </div>    
                <div class="col-md-8 d-none d-md-block divTitulo">
                    Crespán
                </div> 
                <div class="col-md-2 col-sm-3 d-none d-sm-block">
                    login
                    <?php echo $_SESSION['login']; ?>
                </div>

            </div>
        </div>

        <!-- Nuevo menú dinámico -->
        <div class="container-fluid" id="capaMenuDinamico">
            <?php
            require_once 'controladores/C_Menu.php';
            $menuController = new C_Menu();
            $menuController->getVistaMenu();
            ?>
        </div>

        <!-- Menú original -->
        <!-- <div class="container-fluid" id="capaMenu">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown link
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" onclick="obtenerVista('Usuarios', 'getVistaFiltros', 'capaContenido');">Usuarios</a></li>  <!-- Llamamos al js mediante el onclick -->
                                <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>  -->
                            <!-- </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div> --> 

        <div class="container-fluid" id="capaContenido">
        </div>

        <script src="app.js" async></script>  <!-- Ponemos async para que pueda cargar todo mientras podemos seguir manipulando la web, en vez de parar hasta cargar todo; esto es cargar info de manera asincrona -->

    </body>
</html>