<h2>Mantenimiento de Usuarios</h2>
<div class="container-fluid" id="capaFiltrosBusqueda">

    <form id="formularioBuscar" name="formularioBuscar">
        <div class="row">
            <div class="form-group col-md-6 col-sm-12"> 
                <label for="ftexto">Nombre/texto:</label>
                <input type="text" id="ftexto" name="ftexto" class="form-control" placeholder="Texto a buscar" value=""> </input> <!-- importante el name; la class es una específica de bootstrap -->
            </div>
            <div class="form-group col-md-6 col-sm-12"> 
                <label for="factivo">Estado:</label>
                <select id="factivo" name="factivo" class="form-control" > 
                    <option value="" selected>Todos</option>
                    <option value="S">Activos</option>
                    <option value="N">No activos</option>
                </select>
            </div>
        </div>
    

        <div class="row">
            <div class="col-lg-12 mt-2">
                <button type="button" class="btn btn-primary" 
                onclick="buscar('Usuarios', 'getVistaListadoUsuarios', 'formularioBuscar', 'capaResultadosBusqueda')"
                >Buscar</button> <!-- Todo lo que veamos en class extra son clases de bootstrap, en este caso btn para botón y del tipo btn-primary (que sea azul) -->
            
                <button type="button" class="btn btn-secondary" 
                onclick="obtenerVista_EditarCrear('Usuarios', 'getVistaNuevoEditar', 'capaEditarCrear', '')"
                >Nuevo</button>
            </div>
        </div>  
    </form>
    
</div>
    

<div class="container-fluid" id="capaResultadosBusqueda"></div>

<div class="container-fluid" id="capaEditarCrear"></div>