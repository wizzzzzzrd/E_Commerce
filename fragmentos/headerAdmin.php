<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santo Cielo</title>
    <!-- FUENTES Y TIPOGRAFIA -->
    <link rel="stylesheet" href="css/fonts.css">
    <!-- LINKS DE BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Script Font Awesome -->
    <script src="https://kit.fontawesome.com/1fc2543a6c.js" crossorigin="anonymous"></script>
    <!-- Css de detalles-->
    <link rel="stylesheet" href="css/makeUp.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    /* Clase para dar margen lateral al contenido del navbar */
    .nav-content-margins {
        padding-left: 2.5% !important;
        padding-right: 2.5% !important;
    }
</style>

<!-- Menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top w-100" style="background-color:#000 !important; background-image:none !important; box-shadow:none !important; border-bottom: none !important;">
    <div class="container-fluid p-1 nav-content-margins">
        <!-- Botón para el menú hamburguesa -->
        <button class="navbar-toggler font-menu" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo en el centro -->
        <a class="navbar-brand mx-auto d-flex align-items-center py-0" href="admin_dashboard.php">
            <img src="imagenes/logo.png" alt="Santo Cielo" class="img-fluid" style="max-height: 3rem; width: auto; margin-top: -0.5rem; margin-bottom: -0.5rem;">
        </a>

        <!-- Icono del logout en móvil (derecha) -->
        <button id="logout-button" class="btn btn-link text-white text-decoration-none d-lg-none font-menu" type="button" aria-label="Cerrar sesión móvil">
            <i class="fa-solid fa-right-from-bracket"></i>
        </button>

        <!-- Contenido del menú -->
        <div class="collapse navbar-collapse font-menu" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="Cimagenes.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="Ccategorias.php">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="vistaPedidos.php">Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="vistaPedidosDetail.php">Detalles de Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="vistaEnviosDetail.php">Detalles de Envios</a>
                </li>
            </ul>

            <!-- Botón de cerrar sesión en pantallas grandes -->
            <button id="logout-buttonn" class="btn btn-link text-white text-decoration-none d-none d-lg-block font-menu" type="button">
                <i class="fa-solid fa-right-from-bracket"></i> cerrar Sesión
            </button>
        </div>
    </div>
</nav>

<body>
    <!-- Mantengo la misma estructura de margen que en el primer fragmento -->
    <div class="content-wrapper" style="margin: 0 5%;">
        <!-- Espacio superior para compensar el navbar fixed -->
        <div style="height: 4.5rem;"></div>

        <!-- Aquí va el contenido de la página -->
        <!-- ... -->

    </div>

    <!-- Scripts -->
    <script>
        // Envolver en DOMContentLoaded para evitar errores si el script
        // se ejecuta antes de que existan los elementos.
        document.addEventListener('DOMContentLoaded', function () {
            var logoutMobile = document.getElementById('logout-button');
            var logoutDesktop = document.getElementById('logout-buttonn');

            if (logoutMobile) {
                logoutMobile.addEventListener('click', function () {
                    window.location.href = 'controlador/logout.php';
                });
            }
            if (logoutDesktop) {
                logoutDesktop.addEventListener('click', function () {
                    window.location.href = 'controlador/logout.php';
                });
            }
        });
    </script>
</body>

</html>
