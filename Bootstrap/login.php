<?php session_start();
    $usuario = '';
    $pass = '';
    extract($_POST);

    if($usuario == '' OR $pass == '') {
        $msj = 'Por favor, introduzca usuario y contraseña';
    } else {
        // verificar usuario y contraseña en la bbdd
        require_once 'controladores/C_Usuarios.php';
        $objCont = new C_Usuarios();
        $id_Usuario = $objCont->validarUsuario(array('usuario' => $usuario, 'pass' => $pass));  

        if($id_Usuario != '') {
            header('Location: index.php'); // Redirigir al usuario a la página principal
            
        } else {
            unset($_SESSION['login']); // Eliminar la variable de sesión
            unset($_SESSION['id_Usuario']);
            $msj = 'Usuario y/o contraseña incorrectos';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <style>
        /* CSS for login form */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f2f4f8;
        }

        .contenedor {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            color: #333333;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            color: #495057;
            background-color: #f8f9fa;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
            background-color: #ffffff;
        }

        .msj {
            font-size: 12px;
            color: #e74c3c;
            text-align: center;
        }

        .elementFormCentrado {
            text-align: center;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="js/app.js"></script>
</head>

<body>
    <div class="contenedor">
        <section id="seccentrar">
            <form id="formularioLogin" method="POST" action="login.php">
                <div class="elementForm">
                    <label for="usuario">Usuario</label><br>
                    <input type="text" name="usuario" id="usuario" value="" <?php echo $usuario; ?>>
                </div>
                <div class="elementForm">
                    <label for="pass">Password</label>
                    <input type="password" name="pass" id="pass" value="" <?php echo $pass; ?>>
                </div>
                <span id="msj" class="msj"><?php echo $msj; ?></span>
                <div class="elementFormCentrado">
                    <button type="submit" id="aceptar" onclick>Entrar</button>
                </div>
            </form>
        </section> 
    </div>
</body>
</html>
