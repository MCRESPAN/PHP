<?php //echo json_encode($datos); 
    $titulo = '';
    $url = '';
    $nivel = 1;
    $padre_id = '';
    $orden = '';
    $es_dropdown = 0;
    $controlador = '';
    $metodo = '';
    $id = '';

    if(isset($datos['menu_item'])) {
        extract($datos['menu_item']);
        $editar = 'Editar';
        $titulo_form = 'Editar Menú';
        $controladorMenuItem = $controlador;
        $metodoMenuItem = $metodo;
    } else {
        $editar = 'Nuevo';
        $titulo_form = 'Nuevo Menú';
    }
?>

<h2><?php echo $titulo_form; ?></h2>

<div class="container">
    <form id="formularioMenuItem" name="formularioMenuItem">

        <?php if($editar == 'Editar') { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php } ?>

        <!-- Título del Menú -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Título del menú" 
                    value="<?php echo $titulo; ?>" required>
            </div>

            <!-- URL -->
            <div class="form-group col-md-6 col-sm-12">
                <!-- <label for="url">URL:</label> -->
                <input type="hidden" id="url" name="url" class="form-control" placeholder="URL"
                    value="<?php echo $url; ?>">
            </div>
        </div>

        <!-- Nivel y Padre ID -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <!-- <label for="nivel">Nivel:</label> -->
                <input type="hidden" id="nivel" name="nivel" class="form-control" placeholder="Nivel"
                    value="<?php echo $nivel; ?>" required>
            </div>

            <div class="form-group col-md-6 col-sm-12">
                <!-- <label for="padre_id">Padre ID:</label> -->
                <input type="hidden" id="padre_id" name="padre_id" class="form-control" placeholder="Padre ID"
                    value="<?php echo $padre_id; ?>">
            </div>
        </div>

        <!-- Orden y Dropdown -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <!-- <label for="orden">Orden:</label> -->
                <input type="hidden" id="orden" name="orden" class="form-control" placeholder="Orden"
                    value="<?php echo $orden; ?>" required>
            </div>

            <div class="form-group col-md-6 col-sm-12">
                <!-- <label for="es_dropdown">Es Dropdown:</label> -->
                <!-- <select type="hidden" id="es_dropdown" name="es_dropdown" class="form-control" required>
                    <option value="1" <?php if($es_dropdown == 1) echo ('selected'); ?>>Sí</option>
                    <option value="0" <?php if($es_dropdown == 0) echo ('selected'); ?>>No</option>
                </select> -->
            </div>
        </div>

        <!-- Controlador y Método -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="controladorMenuItem">Controlador:</label>
                <input type="text" id="controladorMenuItem" name="controladorMenuItem" class="form-control" placeholder="Controlador"
                    value="<?php echo $controladorMenuItem; ?>">
            </div>

            <div class="form-group col-md-6 col-sm-12">
                <label for="metodoMenuItem">Método:</label>
                <input type="text" id="metodoMenuItem" name="metodoMenuItem" class="form-control" placeholder="Método"
                    value="<?php echo $metodoMenuItem; ?>">
            </div>
        </div>

        <!-- Botones para guardar o cancelar -->
        <div class="row">
            <div class="col-lg-12 mt-2">
                <button type="button" class="btn btn-primary" onclick="guardarMenuItem()"><?php echo $editar; ?></button>

                <button type="button" class="btn btn-secondary" onclick="document.querySelector('.formulario-superpuesto').remove();">
                    Cancelar
                </button>
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
