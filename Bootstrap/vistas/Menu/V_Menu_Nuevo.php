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

        extract($datos['menu_item']);
        $controladorMenuItem = $controlador;
        $metodoMenuItem = $metodo;
        $editar = 'Nuevo';
        $titulo_form = 'Nuevo Menú';
    
    $titulo = '';
    $url = '';
    // nivel no se resetea, el mismo
    // padre_id no se resetea
    $orden = $orden + 1;
    $es_dropdown = 0;
    $controladorMenuItem = '';
    $metodoMenuItem = '';
    $id = '';
?>

<h2><?php echo $titulo_form; ?></h2>

<div class="container">
    <form id="formularioMenuItem" name="formularioMenuItem">

        <?php if($editar == 'Nuevo') { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php } ?>

        <!-- Título del Menú -->
        <div class="row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Título del menú" 
                    value="<?php echo $titulo; ?>" required>
            </div>

            <div class="form-group col-md-6 col-sm-12">
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

        <!-- Los demás campos ocultos -->
        <input type="hidden" id="url" name="url" class="form-control" value="<?php echo $url; ?>">
        <input type="hidden" id="nivel" name="nivel" class="form-control" value="<?php echo $nivel; ?>">
        <input type="hidden" id="padre_id" name="padre_id" class="form-control" value="<?php echo $padre_id; ?>">
        <input type="hidden" id="orden" name="orden" class="form-control" value="<?php echo $orden; ?>">
        <input type="hidden" id="es_dropdown" name="es_dropdown" class="form-control" value="<?php echo $es_dropdown; ?>">

        <!-- Botones para guardar o cancelar -->
        <div class="row">
            <div class="col-lg-12 mt-2">
                <button type="button" class="btn btn-primary" onclick="guardarMenuItem()"><?php echo $editar; ?></button>

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
