
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
        <!-- Encabezado -->
        <div class="container-fluid bg-dark text-white py-2" id="capaEncabezado">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-md-2 col-sm-9 d-none d-sm-block text-center">
                    <img src="img/mcf.png" alt="Logo" class="img-fluid rounded-circle" style="height: 4rem;">
                </div>
                <!-- Título -->
                <div class="col-md-8 d-none d-md-block text-center divTitulo">
                    <h2 class="display-title mb-0">Marcos Crespán Figueras</h2>
                </div>
                <!-- Login -->
                <div class="col-md-2 col-sm-3 text-center">
                    <span class="fw-semibold" style="font-size: 0.9rem;">Login:</span>
                    <span class="text-info" style="font-size: 0.9rem;"><?php echo $_SESSION['login']; ?></span>
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