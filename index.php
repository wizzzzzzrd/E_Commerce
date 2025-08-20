<?php include 'fragmentos/header.php'; ?>
<link rel="stylesheet" href="css/style.css">

<!-- Mensaje de éxito o error -->
<div class="container mt-4">
  <?php if (isset($_GET['msg'])) : ?>
    <?php if ($_GET['msg'] == 'success') : ?>
      <div class="alert alert-success">¡Registro guardado EXITOSAMENTE!</div>
    <?php elseif ($_GET['msg'] == 'warning') : ?>
      <div class="alert alert-warning">Formato NO COMPATIBLE, Intenta con .JPG, .JPEG, .PNG, o, .SVG</div>
    <?php elseif ($_GET['msg'] == 'error') : ?>
      <div class="alert alert-danger">ERROR al guardar el registro</div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<!-- PHP PARA CONSULTA DE IMÁGENES Y CATEGORÍAS -->
<?php
require "modelo/conexion.php";

// Obtener la categoría seleccionada, si existe
$categoryId = isset($_GET['id']) ? intval($_GET['id']) : '';

// Consulta para obtener los productos y sus categorías
$productosSql = $conexion->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.category_id" . ($categoryId ? " WHERE p.category_id = $categoryId" : ""));

// Consulta para obtener las categorías
$categoriasSql = $conexion->query("SELECT DISTINCT c.category_id, c.category_name FROM categories c");
?>

<!-- Contenedor de Productos y Filtro -->

<?php if (empty($categoryId)): ?>
  <!-- Carrusel extendido +6% por lado (se muestra SOLO cuando NO hay categoría seleccionada) -->
  <!-- IMPORTANTE: No uses overflow:hidden en este contenedor ni en sus ancestros si quieres ver el desbordamiento. -->
  <div class="carousel-extended-wrapper" style="position:relative; width:100%; overflow:visible;">
    <div id="carouselExample" class="carousel slide carousel-extended" data-bs-ride="carousel"
      style="position:relative; left: -5.5%; width: calc(100% + 11%);">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="imagenes/SC-Carrousel.png" class="d-block w-100" alt="Imagen 1" style="object-fit:cover; width:100%; height:auto; display:block;">
        </div>
        <div class="carousel-item">
          <img src="imagenes/SC-Carrousel-1.png" class="d-block w-100" alt="Imagen 2" style="object-fit:cover; width:100%; height:auto; display:block;">
        </div>
        <div class="carousel-item">
          <img src="imagenes/SC-Carrousel-2.png" class="d-block w-100" alt="Imagen 3" style="object-fit:cover; width:100%; height:auto; display:block;">
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="z-index:20;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="z-index:20;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>

      <div class="carousel-indicators" style="z-index:20;">
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Alerta para ir al carrito 
    <div class="alert alert-secondary d-flex justify-content-between align-items-center">
        <span>Bienvenidx a Nuestro E-Commerce</span>
        <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
            <i class="fa-solid fa-bag-shopping"></i> Ver Bolsa
        </button>
    </div>-->
<br>
<!-- Navegación de Categorías -->
<div class="mb-4 mt-4 font-subtitle" style="margin-right: 2.5%; margin-left:-2.5%">
  <ul class="list-unstyled d-flex flex-wrap badge-sale">
    <li class="me-3">
      <a href="?id=" class="text-decoration-none text-dark fw-bold hover-underline ">Todo</a>
    </li>

    <?php while ($cat = $categoriasSql->fetch_assoc()) : ?>
      <li class="me-3">
        <a href="?id=<?= htmlspecialchars($cat['category_id']) ?>" class="text-decoration-none text-dark hover-underline"><?= htmlspecialchars($cat['category_name']) ?></a>
      </li>
    <?php endwhile; ?>
  </ul>
</div>

<!-- Contenedor de Productos -->
<div style="margin-right: -3%; margin-left:-3%" id="products-container" class="row gx-4 gy-4">
  <?php while ($datos = $productosSql->fetch_object()) {
    $is_disabled = (isset($datos->product_stock) && intval($datos->product_stock) <= 0)
      || (isset($datos->actions_enabled) && intval($datos->actions_enabled) === 0);

    // Valores limpios
    $product_id    = htmlspecialchars($datos->product_id);
    $product_name  = htmlspecialchars($datos->product_name);
    $product_price = htmlspecialchars($datos->product_price);
    $product_image = htmlspecialchars($datos->product_image);
    $product_image2 = !empty($datos->product_image2) ? htmlspecialchars($datos->product_image2) : '';
    $product_stock = isset($datos->product_stock) ? intval($datos->product_stock) : 0;

    // estilos inline para imgs (ajusta blur aquí si quieres otro valor: e.g. blur(2px) )
    $base_img_style = "object-fit: cover; height: 100%; display:block;";
    if ($is_disabled) {
      $primary_img_style = $base_img_style . " filter: blur(4px) grayscale(25%) brightness(0.9); -webkit-filter: blur(4px) grayscale(25%) brightness(0.9);";
      // secundaria escondida para que no haga el swap al hover
      $secondary_img_style = $base_img_style . " opacity:0;";
      // desactivar enlaces
      $anchor_extra = 'style="pointer-events:none; cursor:default;" aria-disabled="true"';
    } else {
      $primary_img_style = $base_img_style;
      $secondary_img_style = $base_img_style;
      $anchor_extra = '';
    }
  ?>
    <div class="col-6 col-md-4 col-lg-3 product-card font-body <?= $is_disabled ? 'product-disabled' : '' ?>" data-category="<?= htmlspecialchars($datos->category_id) ?>">
      <div class="card h-100 border-0 shadow-sm">
        <!-- Image wrapper -->
        <div class="image-wrapper d-flex justify-content-center align-items-center" style="min-height: 250px;">
          <a href="producto.php?id=<?= $product_id ?>" class="text-dark text-decoration-none font-subtitle" <?= $is_disabled ? 'style="pointer-events:none;cursor:default;" aria-disabled="true"' : '' ?>>
            <a href="producto.php?id=<?= $product_id ?>" class="text-decoration-none" <?= $anchor_extra ?>>
              <!-- Imagen principal -->
              <img
                src="<?= $product_image ?>"
                class="primary-img img-fluid"
                alt="<?= $product_name ?>"
                style="<?= $primary_img_style ?>">
              <!-- Imagen secundaria (mostrada al hover en productos activos) -->
              <?php if ($product_image2): ?>
                <img
                  src="<?= $product_image2 ?>"
                  class="secondary-img img-fluid"
                  alt="<?= $product_name . ' (vista 2)' ?>"
                  style="<?= $secondary_img_style ?>">
              <?php endif; ?>
            </a>

            <!-- NOTA: ya no mostramos overlay sobre la imagen (el "Sin stock" irá en la zona del botón) -->
        </div>

        <div class="card-body text-start">
          <h5 class="card-title">
            <a href="producto.php?id=<?= $product_id ?>" class="text-dark text-decoration-none font-subtitle" <?= $is_disabled ? 'style="pointer-events:none;cursor:default;" aria-disabled="true"' : '' ?>>
              <?= $product_name ?>
            </a>
          </h5>
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-price mb-0 font-price">$<?= $product_price ?></h6>

            <!-- Si NO está deshabilitado mostramos el botón add-to-cart tal como estaba -->
            <?php if (!$is_disabled): ?>
              <button
                class="btn btn-outline-dark add-to-cart font-subtitle"
                type="button"
                data-id="<?= $product_id ?>"
                data-name="<?= $product_name ?>"
                data-price="<?= $product_price ?>"
                data-image="<?= $product_image ?>">
                <i class="fa-solid fa-bag-shopping"></i>
              </button>
            <?php else: ?>
              <!-- Pill en la zona del botón (estilo bootstrap: bg-danger o bg-secondary) -->
              <?php if ($product_stock <= 0): ?>
                <span class="badge bg-danger fw-bold font-subtitle">Sin stock</span>
              <?php else: ?>
                <span class="badge bg-secondary fw-bold font-subtitle">Deshabilitado</span>
              <?php endif; ?>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<!-- CARRITO DE COMPRAS -->
<?php include 'fragmentos/OffCart.php'; ?>

<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>