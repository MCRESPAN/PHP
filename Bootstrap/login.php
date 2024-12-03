<?php 
session_start();
$usuario = '';
$pass = '';
$msj = ''; // Inicializamos el mensaje vacío

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if ($usuario == '' || $pass == '') {
        $msj = 'Por favor, introduzca usuario y contraseña';
    } else {
        require_once 'controladores/C_Usuarios.php';
        $objCont = new C_Usuarios();
        $id_Usuario = $objCont->validarUsuario(array('usuario' => $usuario, 'pass' => $pass));  

        if ($id_Usuario != '') {
            header('Location: index.php'); // Redirigir al usuario a la página principal
            exit;
        } else {
            unset($_SESSION['login']); // Eliminar la variable de sesión
            unset($_SESSION['id_Usuario']);
            $msj = 'Usuario y/o contraseña incorrectos';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Raleway', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f2f4f8; /* Fondo blanco/plateado */
            color: #333333; /* Texto en gris oscuro */
        }

        .contenedor {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #f7f9fc; /* Fondo gris claro elegante */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
            color: #333333; /* Texto oscuro */
        }

        #seccentrar {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .elementForm {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        label {
            font-size: 14px;
            font-weight: bold; /* Texto en negrita */
            color: #10A5E1; /* Azul elegante */
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            color: #495057;
            background-color: #ffffff;
            transition: border-color 0.3s, background-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #10A5E1; /* Azul elegante */
            outline: none;
            background-color: #ffffff;
        }

        .msj {
            font-size: 12px;
            color: #e74c3c; /* Mensaje de error en rojo */
            text-align: center;
            margin-top: -10px;
        }

        .elementFormCentrado {
            text-align: center;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #10A5E1; /* Azul elegante */
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0E84B5; /* Azul más oscuro */
        }
    </style>
    <script src="js/app.js"></script>
</head>

<body>
    <div class="contenedor">
        <section id="seccentrar">
            <form id="formularioLogin" method="POST" action="login.php">
                <div class="elementForm">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
                </div>
                <div class="elementForm">
                    <label for="pass">Password</label>
                    <input type="password" name="pass" id="pass" value="<?php echo htmlspecialchars($pass); ?>">
                </div>
                <?php if (!empty($msj)): ?>
                    <span id="msj" class="msj"><?php echo $msj; ?></span>
                <?php endif; ?>
                <div class="elementFormCentrado">
                    <button type="submit" id="aceptar">Entrar</button>
                </div>
            </form>
        </section> 
    </div>
</body>
</html>
