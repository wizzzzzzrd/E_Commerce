<?php include 'fragmentos/header.php'; ?>
<br><br><br>
<link rel="stylesheet" href="css/style.css">

<?php
require "modelo/conexion.php";

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$productoSql = $conexion->query(
    "SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.category_id WHERE p.product_id = $productId"
);

if ($productoSql->num_rows > 0) {
    $producto = $productoSql->fetch_object();
    $sugeridosSql = $conexion->query("SELECT * FROM products WHERE product_id != $productId ORDER BY RAND() LIMIT 8");
?>
    <div class="row gy-4" style="margin-right: -3%; margin-left:-3%">

        <!-- Miniaturas (solo desktop) -->
        <div class="col-md-1 d-none d-md-flex flex-column align-items-center gap-2" style="padding-top: 8px;">
            <a href="#" onclick="switchImage(this, 'mainImg'); return false;"
               data-src="<?= htmlspecialchars($producto->product_image) ?>"
               class="thumb-link active-thumb">
                <img src="<?= htmlspecialchars($producto->product_image) ?>"
                     alt="Vista 1"
                     style="width:60px; height:60px; object-fit:cover; border-radius:4px; border:2px solid #000;">
            </a>
            <?php if (!empty($producto->product_image2)): ?>
                <a href="#" onclick="switchImage(this, 'mainImg'); return false;"
                   data-src="<?= htmlspecialchars($producto->product_image2) ?>"
                   class="thumb-link">
                    <img src="<?= htmlspecialchars($producto->product_image2) ?>"
                         alt="Vista 2"
                         style="width:60px; height:60px; object-fit:cover; border-radius:4px; border:2px solid transparent;">
                </a>
            <?php endif; ?>
        </div>

        <!-- Imagen principal desktop + carousel mobile -->
        <div class="col-12 col-md-5">
            <!-- Carousel solo en móvil -->
            <div id="mobileCarousel" class="carousel slide d-md-none" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= htmlspecialchars($producto->product_image) ?>" class="d-block w-100" alt="Vista 1">
                    </div>
                    <?php if (!empty($producto->product_image2)): ?>
                        <div class="carousel-item">
                            <img src="<?= htmlspecialchars($producto->product_image2) ?>" class="d-block w-100" alt="Vista 2">
                        </div>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mobileCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mobileCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
            <!-- Imagen fija solo desktop -->
            <div class="d-none d-md-block">
                <img id="mainImg"
                     src="<?= htmlspecialchars($producto->product_image) ?>"
                     class="img-fluid"
                     alt="<?= htmlspecialchars($producto->product_name) ?>"
                     style="width:100%; max-height:650px; object-fit:contain;">
            </div>
        </div>

        <!-- Detalles -->
        <div class="col-12 col-md-6">
            <h2 class="mb-3 mt-3 mt-md-5 font-title"><?= htmlspecialchars($producto->product_name) ?></h2>
            <h4 class="mb-3 font-price">$<?= htmlspecialchars($producto->product_price) ?> MXN</h4>

            <div class="mb-4">
                <a href="#" class="text-dark font-subtitle" data-bs-toggle="modal" data-bs-target="#sizeChartModal">☻ Tabla de Tallas</a>
            </div>

            <div class="mb-4">
                <span class="me-2 font-subtitle">Talla:</span>
                <button class="btn btn-outline-dark me-1 font-subtitle">S</button>
                <button class="btn btn-outline-dark me-1 font-subtitle">M</button>
                <button class="btn btn-outline-dark me-1 font-subtitle">L</button>
                <button class="btn btn-outline-dark me-1 font-subtitle">XL</button>
                <button class="btn btn-outline-dark font-subtitle">XXL</button>
            </div>

            <?php
            $is_disabled = (isset($producto->product_stock) && intval($producto->product_stock) <= 0)
                || (isset($producto->actions_enabled) && intval($producto->actions_enabled) === 0);

            if (!$is_disabled): ?>
                <button class="btn btn-outline-dark add-to-cart btn-lg mb-4 fw-bold w-100 font-subtitle" type="button"
                    data-id="<?= htmlspecialchars($producto->product_id) ?>"
                    data-name="<?= htmlspecialchars($producto->product_name) ?>"
                    data-price="<?= htmlspecialchars($producto->product_price) ?>"
                    data-image="<?= htmlspecialchars($producto->product_image) ?>">
                    <i class="fa-solid fa-bag-shopping"></i> Agregar al Carrito
                </button>
            <?php else:
                $producto_stock = isset($producto->product_stock) ? intval($producto->product_stock) : 0;
                if ($producto_stock <= 0): ?>
                    <div class="mb-4">
                        <span class="badge bg-danger fw-bold d-inline-block w-100 text-center py-2 font-subtitle" aria-disabled="true">SIN STOCK</span>
                    </div>
                <?php else: ?>
                    <div class="mb-4">
                        <span class="badge bg-secondary fw-bold d-inline-block w-100 text-center py-2 font-subtitle" aria-disabled="true">DESHABILITADO</span>
                    </div>
            <?php endif;
            endif; ?>

            <div class="accordion mb-1" id="productAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDescription">
                        <button class="accordion-button font-subtitle" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription" aria-expanded="true" aria-controls="collapseDescription">
                            Descripción
                        </button>
                    </h2>
                    <div id="collapseDescription" class="accordion-collapse collapse show" aria-labelledby="headingDescription" data-bs-parent="#productAccordion">
                        <div class="accordion-body">
                            <p class="font-body"><?= htmlspecialchars($producto->product_description) ?></p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDetails">
                        <button class="accordion-button collapsed font-subtitle" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetails" aria-expanded="false" aria-controls="collapseDetails">
                            Detalles
                        </button>
                    </h2>
                    <div id="collapseDetails" class="accordion-collapse collapse" aria-labelledby="headingDetails" data-bs-parent="#productAccordion">
                        <div class="accordion-body font-body">
                            Disponibilidad hasta agotar existencias.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos Sugeridos -->
    <h3 class="mt-5 mb-3 font-subtitle" style="margin-right: -2%; margin-left:-2%">Productos Sugeridos</h3>
    <div id="products-container" class="row gx-4 gy-4" style="margin-right: -3%; margin-left:-3%">
        <?php while ($suggest = $sugeridosSql->fetch_object()) {
            $is_disabled = (isset($suggest->product_stock) && intval($suggest->product_stock) <= 0)
                || (isset($suggest->actions_enabled) && intval($suggest->actions_enabled) === 0);

            $product_id     = htmlspecialchars($suggest->product_id);
            $product_name   = htmlspecialchars($suggest->product_name);
            $product_price  = htmlspecialchars($suggest->product_price);
            $product_image  = htmlspecialchars($suggest->product_image);
            $product_image2 = !empty($suggest->product_image2) ? htmlspecialchars($suggest->product_image2) : '';
            $product_stock  = isset($suggest->product_stock) ? intval($suggest->product_stock) : 0;

            $base_img_style = "object-fit: cover; height: 100%; display:block; transition: opacity .28s ease, filter .28s ease;";
            if ($is_disabled) {
                $primary_img_style  = $base_img_style . " filter: blur(4px) grayscale(25%) brightness(0.9); -webkit-filter: blur(4px) grayscale(25%) brightness(0.9);";
                $secondary_img_style = "";
                $anchor_extra       = 'style="pointer-events:none; cursor:default;" aria-disabled="true"';
                $secondary_render   = false;
            } else {
                $primary_img_style  = $base_img_style;
                $secondary_img_style = $base_img_style . " opacity:0;";
                $anchor_extra       = '';
                $secondary_render   = (bool)$product_image2;
            }

            if (!$is_disabled && $secondary_render) {
                $hover_handlers = 'onmouseenter="(function(){var p=this.querySelector(\'.primary-img\'); var s=this.querySelector(\'.secondary-img\'); if(p) p.style.opacity=\'0\'; if(s) s.style.opacity=\'1\'; }).call(this)" '
                    . 'onmouseleave="(function(){var p=this.querySelector(\'.primary-img\'); var s=this.querySelector(\'.secondary-img\'); if(p) p.style.opacity=\'1\'; if(s) s.style.opacity=\'0\'; }).call(this)"';
            } else {
                $hover_handlers = '';
            }
        ?>
            <div class="col-6 col-md-4 col-lg-3 product-card font-body <?= $is_disabled ? 'product-disabled' : '' ?>" data-category="<?= htmlspecialchars($suggest->category_id) ?>">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="image-wrapper d-flex justify-content-center align-items-center" style="min-height: 150px;">
                        <a href="producto.php?id=<?= $product_id ?>" class="text-decoration-none" <?= $anchor_extra ?> <?= $hover_handlers ?>>
                            <img src="<?= $product_image ?>"
                                 class="primary-img img-fluid"
                                 alt="<?= $product_name ?>"
                                 style="<?= $primary_img_style ?>">
                            <?php if ($secondary_render): ?>
                                <img src="<?= $product_image2 ?>"
                                     class="secondary-img img-fluid"
                                     alt="<?= $product_name ?> (vista 2)"
                                     style="<?= $secondary_img_style ?>">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-body text-start">
                        <h5 class="card-title">
                            <a href="producto.php?id=<?= $product_id ?>" class="text-dark text-decoration-none font-subtitle"
                               <?= $is_disabled ? 'style="pointer-events:none;cursor:default;" aria-disabled="true"' : '' ?>>
                                <?= $product_name ?>
                            </a>
                        </h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-price mb-0 font-price">$<?= $product_price ?></h6>
                            <?php if (!$is_disabled): ?>
                                <button class="btn btn-outline-dark add-to-cart font-subtitle" type="button"
                                    data-id="<?= $product_id ?>"
                                    data-name="<?= $product_name ?>"
                                    data-price="<?= $product_price ?>"
                                    data-image="<?= $product_image ?>">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </button>
                            <?php else: ?>
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

    <!-- Volver -->
    <div class="d-flex justify-content-center mt-5">
        <a href="index.php" class="btn btn-outline-dark fw-bold font-subtitle">
            <i class="fa-solid fa-arrow-left"></i> Volver a la colección
        </a>
    </div>

<?php } else {
    echo "<p>Producto no encontrado.</p>";
} ?>

<!-- Modal Tabla de Tallas -->
<div class="modal fade" id="sizeChartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-subtitle">Tabla de Tallas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="imagenes/tallas.png" class="img-fluid" alt="Tabla de Tallas">
            </div>
        </div>
    </div>
</div>

<?php include 'fragmentos/OffCart.php'; ?>
<?php include 'fragmentos/footer.php'; ?>

<script>
    function switchImage(el, targetId) {
        document.getElementById(targetId).src = el.getAttribute('data-src');
        document.querySelectorAll('.thumb-link img').forEach(function(img) {
            img.style.border = '2px solid transparent';
        });
        el.querySelector('img').style.border = '2px solid #000';
    }
</script>
