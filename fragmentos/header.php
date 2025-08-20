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
        <a class="navbar-brand mx-auto d-flex align-items-center py-0" href="index.php">
            <img src="imagenes/logo.png" alt="Santo Cielo" class="img-fluid" style="max-height: 3rem; width: auto; margin-top: -0.5rem; margin-bottom: -0.5rem;">
        </a>

        <!-- Icono del carrito a la derecha -->
         <button class="btn btn-link text-white text-decoration-none d-lg-none font-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
            <i class="fa-solid fa-bag-shopping"></i>
            <span class="badge bg-danger" id="cart-count-mobile">0</span>
        </button>

        <!-- Contenido del menú -->
       <div class="collapse navbar-collapse font-menu" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="index.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="nosotros.php">Sobre Nosotros</a>
                </li>
                <?php
                if (!isset($conexion)) {
                    require 'modelo/conexion.php';
                }
                $categoriasSql = $conexion->query("SELECT DISTINCT category_id, category_name FROM categories");
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Clothing
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                        <li>
                            <a class="dropdown-item" href="index.php?id=">Todo</a>
                        </li>
                        <?php if ($categoriasSql && $categoriasSql->num_rows > 0): ?>
                            <?php while ($cat = $categoriasSql->fetch_assoc()): ?>
                                <li>
                                    <a class="dropdown-item" href="index.php?id=<?= htmlspecialchars($cat['category_id']) ?>">
                                        <?= htmlspecialchars($cat['category_name']) ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li><span class="dropdown-item-text">No hay categorías</span></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>

            <!-- Icono del carrito en pantallas grandes -->
            <button class="btn btn-link text-white text-decoration-none d-none d-lg-block poppins-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="badge bg-danger" id="cart-count-desktop">0</span>
            </button>
        </div>
    </div>
</nav>

<body>
    <div class="content-wrapper" style="margin: 0 5%;">