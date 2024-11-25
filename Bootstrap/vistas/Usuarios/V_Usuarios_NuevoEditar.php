<?php //echo json_encode($datos); 
    $nombre = '';
    $apellido_1 = '';     
    $apellido_2 = '';
    $sexo = '';
    $fecha_alta = date('Y-m-d');
    $mail = '';
    $movil = '';
    $login = '';
    $activo = 'S';
    $id_Usuario = '';
    if(isset($datos['usuario'])) {
        extract($datos['usuario']);
        $editar = 'Editar';
        $titulo = 'Editar Usuario';
    }else{
        $editar = 'Nuevo';
        $titulo = 'Nuevo Usuario';
    }
?>

<h2><?php echo $titulo; ?></h2>

<div class="container">
    <form id="formularioUsuario" name="formularioUsuario">

        <?php if($editar == 'Editar') { ?>
            <input type="hidden" name="id_Usuario" value="<?php echo $id_Usuario; ?>">
        <?php } ?>

        <!-- Nombre del usuario -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del usuario" 
                    value="<?php echo $nombre; ?>" required>
            </div>

            <!-- Primer apellido del usuario -->
            <div class="form-group col-md-6 col-sm-12">
                <label for="apellido_1">Primer Apellido:</label>
                <input type="text" id="apellido_1" name="apellido_1" class="form-control" placeholder="Primer apellido"
                    value="<?php echo $apellido_1; ?>" required>
            </div>
        </div>

        <!-- Segundo apellido del usuario -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="apellido_2">Segundo Apellido:</label>
                <input type="text" id="apellido_2" name="apellido_2" class="form-control" placeholder="Segundo apellido"
                    value="<?php echo $apellido_2; ?>">
            </div>

            <!-- Estado del usuario -->
            <div class="form-group col-md-6 col-sm-12">
                <label for="activo">Estado:</label>
                <select id="activo" name="activo" class="form-control" required>
                    <option value="S" <?php if($activo == 'S') echo ('selected'); ?>>Activo</option>
                    <option value="N" <?php if($activo == 'N') echo ('selected'); ?>>No Activo</option>
                </select>
            </div>
        </div>

        <!-- Login (Nombre de Usuario) -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="login">Nombre de Usuario (Login):</label>
                <input type="text" id="login" name="login" class="form-control" placeholder="Nombre de usuario"
                    value="<?php echo $login; ?>" required>
            </div>

            <!-- Sexo del usuario -->
            <div class="form-group col-md-6 col-sm-12">
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" class="form-control" required>
                    <option value="M" <?php if($sexo == 'M') echo ('M'); ?>>Masculino</option>
                    <option value="F" <?php if($sexo == 'F') echo ('F'); ?>>Femenino</option>
                    <option value="O" <?php if($sexo == 'O') echo ('O'); ?>>Otro</option>
                </select>
            </div>
        </div>

        
        <div class="row">
            <!-- Mail del usuario -->
            <div class="form-group col-md-6 col-sm-12">
                <label for="mail">Mail:</label>
                <input type="email" id="mail" name="mail" class="form-control" placeholder="Mail"
                    value="<?php echo $mail; ?>" required>
            </div>

            <!-- Fecha de Alta del usuario -->
            <div class="row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="fecha_alta">Fecha de Alta:</label>
                    <input type="date" id="fecha_alta" name="fecha_alta" class="form-control"
                        value="<?php echo $fecha_alta; ?>" required>
                </div>
            </div>
        </div>

        <!-- Botones para guardar o cancelar -->
        <div class="row">
            <div class="col-lg-12 mt-2">
                <button type="button" class="btn btn-primary" onclick="guardarUsuario()"><?php echo $editar; ?></button>

                <button type="button" class="btn btn-secondary" onclick="document.getElementById('capaEditarCrear').innerHTML = '';">Cancelar</button>
            </div>
        </div>
        <!-- Contenedor para el mensaje de error -->
        <div class="row">
            <div class="col-lg-12">
                <span id="msjError" name="msjError" style="color:blue; display: block; margin-top: 10px;"></span>
            </div>
        </div>
    </form>
</div>
