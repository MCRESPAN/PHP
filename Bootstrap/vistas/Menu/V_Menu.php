<?php
$menuItems = $datos['menuItems'];

function construirMenu($items) {
    $html = '';
    foreach ($items as $item) {
        if ($item['nivel'] == 1) {
            if ($item['es_dropdown']) {
                $html .= '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ' . $item['titulo'] . '
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                foreach ($items as $subitem) {
                    if ($subitem['padre_id'] == $item['id']) {
                        if ($subitem['controlador'] && $subitem['metodo']) {
                            $html .= '<li><a class="dropdown-item" onclick="obtenerVista(\'' . $subitem['controlador'] . '\', \'' . $subitem['metodo'] . '\', \'capaContenido\')">' . $subitem['titulo'] . '</a></li>';
                        } else {
                            $html .= '<li><a class="dropdown-item" href="' . $subitem['url'] . '">' . $subitem['titulo'] . '</a></li>';
                        }
                    }
                }
                $html .= '</ul></li>';
            } else {
                $html .= '<li class="nav-item">
                    <a class="nav-link' . ($item['orden'] == 1 ? ' active" aria-current="page' : '"') . ' href="' . $item['url'] . '">' . $item['titulo'] . '</a>
                </li>';
            }
        }
    }
    return $html;
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Menu dinámico desde la Base de Datos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <?php echo construirMenu($menuItems); ?>
            </ul>
        </div>
    </div>
</nav>