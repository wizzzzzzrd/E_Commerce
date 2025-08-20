<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fragmentos/headerAdmin.php'; ?>

<!-- Mensaje de éxito o error -->
<div class="container mt-4">
    <?php if (isset($_GET['msg'])) : ?>
        <?php if ($_GET['msg'] == 'success') : ?>
            <div class="alert alert-success font-body">¡Registro guardado EXITOSAMENTE!</div>
        <?php elseif ($_GET['msg'] == 'warning') : ?>
            <div class="alert alert-warning font-body">Formato NO COMPATIBLE, Intenta con .JPG, .JPEG, .PNG, o .SVG</div>
        <?php elseif ($_GET['msg'] == 'error') : ?>
            <div class="alert alert-danger font-body">ERROR al guardar el registro</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="container">
    <!-- Inicio de Galería interactiva -->
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark font-title">Control de Productos</h1>

    <!-- PHP PARA CONSULTA DE PRODUCTOS -->
    <?php
    require "modelo/conexion.php";
    // Consulta para obtener los productos y sus categorías
    $sql = $conexion->query("
        SELECT p.*, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id
    ");
    ?>

    <!-- MODAL DE BOTÓN DE REGISTRO -->
    <div class="container mt-4">
        <button type="button" class="btn btn-primary font-subtitle" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Nuevo
        </button>
    </div>

    <!-- Modal Nuevo Producto -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-subtitle" id="exampleModalLabel">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="controlador/registrarProducto.php" enctype="multipart/form-data" method="POST">
                        <div class="mb-3">
                            <label for="imagen" class="form-label font-body">Imagen del Producto</label>
                            <input type="file" class="form-control font-body" id="imagen" name="product_image" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen2" class="form-label font-body">Segunda Imagen del Producto</label>
                            <input type="file" class="form-control font-body" id="imagen2" name="product_image2" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label font-body">Nombre del Producto</label>
                            <input type="text" class="form-control font-body" id="nombre" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label font-body">Descripción</label>
                            <textarea class="form-control font-body" id="descripcion" name="product_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label font-body">Stock</label>
                            <input type="number" class="form-control font-body" id="stock" name="product_stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label font-body">Precio</label>
                            <input type="text" class="form-control font-body" id="precio" name="product_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label font-body">Categoría</label>
                            <select class="form-select font-body" id="categoria" name="category_id" required>
                                <option value="" selected disabled>Selecciona una categoría</option>
                                <?php
                                $categorias = $conexion->query("SELECT * FROM categories");
                                while ($categoria = $categorias->fetch_object()) {
                                    echo "<option value='{$categoria->category_id}'>{$categoria->category_name}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="submit" name="btnregistrar" value="Registrar" class="form-control btn btn-success font-subtitle">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Producto -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-subtitle" id="editModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="controlador/editarProducto.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="product_id">
                        <div class="mb-3">
                            <label for="editImagen" class="form-label font-body">Imagen del Producto</label>
                            <input type="file" class="form-control font-body" id="editImagen" name="product_image">
                        </div>
                        <div class="mb-3">
                            <label for="editImagen2" class="form-label font-body">Segunda Imagen del Producto</label>
                            <input type="file" class="form-control font-body" id="editImagen2" name="product_image2">
                        </div>
                        <div class="mb-3">
                            <label for="editNombre" class="form-label font-body">Nombre del Producto</label>
                            <input type="text" class="form-control font-body" id="editNombre" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label font-body">Descripción</label>
                            <textarea class="form-control font-body" id="editDescripcion" name="product_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editStock" class="form-label font-body">Stock</label>
                            <input type="number" class="form-control font-body" id="editStock" name="product_stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label font-body">Precio</label>
                            <input type="text" class="form-control font-body" id="editPrecio" name="product_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoria" class="form-label font-body">Categoría</label>
                            <select class="form-select font-body" id="editCategoria" name="category_id" required>
                                <option value="" selected disabled>Selecciona una categoría</option>
                                <?php
                                $categorias = $conexion->query("SELECT * FROM categories");
                                while ($categoria = $categorias->fetch_object()) {
                                    echo "<option value='{$categoria->category_id}'>{$categoria->category_name}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="submit" name="btneditar" value="Guardar Cambios" class="form-control btn btn-success font-subtitle">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor Productos -->
    <!-- Contenedor Productos -->
    <div class="container mt-4">
        <div class="row gx-5 gy-4">
            <!-- Tarjetas de Productos -->
            <?php
            // Nota: $sql viene de tu consulta anterior: SELECT p.*, c.category_name ...
            while ($datos = $sql->fetch_object()) {
                $pid = (int)$datos->product_id;
                $pname = htmlspecialchars($datos->product_name);
                $pprice = htmlspecialchars($datos->product_price);
                $pdesc = htmlspecialchars($datos->product_description);
                $pstock = (int)$datos->product_stock;
                $pimg = htmlspecialchars($datos->product_image);
                // fallback si actions_enabled no existe (por seguridad)
                $actions_enabled = isset($datos->actions_enabled) ? (int)$datos->actions_enabled : 1;
                $is_disabled = ($pstock <= 0) || ($actions_enabled === 0);
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card bg-light h-100 product-card <?php if ($is_disabled) echo 'product-disabled'; ?>" data-product-id="<?= $pid ?>" data-actions-enabled="<?= $actions_enabled ?>">
                        <div class="product-image-wrap position-relative">
                            <img src="<?= $pimg ?>"
                                 class="card-img-top"
                                 alt="<?= $pname ?>"
                                 style="height: 200px; object-fit: cover;">
                            <?php if ($is_disabled): ?>
                                <div class="product-overlay">
                                    <div class="overlay-text text-center font-body">
                                        <?php if ($pstock <= 0): ?>
                                            <span class="badge bg-danger">Sin stock</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Deshabilitado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title font-subtitle"><?= $pname ?></h5>
                            <h6 class="card-title font-subtitle">$<?= $pprice ?></h6>
                            <p class="card-text font-body"><?= $pdesc ?></p>
                            <p class="card-text font-body"><strong>Stock:</strong> <?= $pstock ?></p>

                            <!-- Acciones: editar / borrar -->
                            <a href="#"
                               class="btn btn-warning me-1 font-subtitle"
                               data-bs-toggle="modal"
                               data-bs-target="#editModal"
                               onclick="fillEditForm(
                                   <?= $pid ?>,
                                   '<?= addslashes($pname) ?>',
                                   '<?= addslashes($pdesc) ?>',
                                   '<?= addslashes($pprice) ?>',
                                   <?= (int)$datos->category_id ?>,
                                   <?= $pstock ?>
                               )">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <a href="#"
                               class="btn btn-danger me-1 font-subtitle"
                               onclick="confirmDelete(<?= $pid ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                            <!-- Botón ojo: alterna actions_enabled -->
                            <button class="btn btn-outline-primary toggle-visibility font-subtitle" data-id="<?= $pid ?>" title="Mostrar/ocultar acciones">
                                <i class="fa-solid <?= $is_disabled ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                            </button>

                            <div class="position-relative">
                                <div class="position-absolute bottom-0 end-0 p-2 text-dark">
                                    <h6 class="font-subtitle">#<?= $pid ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <style>
        /* overlay y blur */
        .product-image-wrap { position: relative; overflow: hidden; }
        .product-overlay {
            position: absolute;
            inset: 0;
            display:flex;
            align-items:center;
            justify-content:center;
            background: rgba(255,255,255,0.45);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }
        .product-disabled .card-body,
        .product-disabled .card-title,
        .product-disabled .card-text {
            color: #6c757d;
        }
        .product-disabled img { filter: grayscale(20%) brightness(0.9); }
    </style>

    <script>
        // Delegación de evento para los botones ojo
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.toggle-visibility');
            if (!btn) return;
            e.preventDefault();
            var productId = btn.dataset.id;
            btn.disabled = true;

            var form = new FormData();
            form.append('product_id', productId);

            fetch('controlador/toggle_visibility.php', {
                method: 'POST',
                body: form,
                credentials: 'same-origin'
            })
            .then(r => r.json())
            .then(data => {
                if (data && data.success) {
                    // actualizar UI: icono y clase de la tarjeta
                    var card = document.querySelector('.product-card[data-product-id="'+productId+'"]');
                    if (!card) return;
                    var enabled = data.enabled == 1;
                    var icon = btn.querySelector('i');
                    if (enabled) {
                        card.classList.remove('product-disabled');
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        card.classList.add('product-disabled');
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                } else {
                    alert('No se pudo alternar visibilidad: ' + (data.msg || 'error'));
                }
            })
            .catch(err => {
                console.error('Error toggle visibility', err);
                alert('Error al comunicarse con el servidor.');
            })
            .finally(()=> btn.disabled = false);
        });
    </script>
        <div class="row gx-5 gy-4">
            <!-- Tarjetas de Productos -->
            <?php while ($datos = $sql->fetch_object()) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card bg-light h-100">
                        <img src="<?= htmlspecialchars($datos->product_image) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($datos->product_name) ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title font-subtitle"><?= htmlspecialchars($datos->product_name) ?></h5>
                            <h6 class="card-title font-subtitle">$<?= htmlspecialchars($datos->product_price) ?></h6>
                            <p class="card-text font-body"><?= htmlspecialchars($datos->product_description) ?></p>
                            <p class="card-text font-body"><strong>Stock:</strong> <?= htmlspecialchars($datos->product_stock) ?></p>
                            <a href="#"
                               class="btn btn-warning me-1 font-subtitle"
                               data-bs-toggle="modal"
                               data-bs-target="#editModal"
                               onclick="fillEditForm(
                                   <?= $datos->product_id ?>,
                                   '<?= addslashes(htmlspecialchars($datos->product_name)) ?>',
                                   '<?= addslashes(htmlspecialchars($datos->product_description)) ?>',
                                   '<?= $datos->product_price ?>',
                                   <?= $datos->category_id ?>,
                                   <?= $datos->product_stock ?>
                               )">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#"
                               class="btn btn-danger font-subtitle"
                               onclick="confirmDelete(<?= $datos->product_id ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <div class="position-relative">
                                <div class="position-absolute bottom-0 end-0 p-2 text-dark">
                                    <h6 class="font-subtitle">#<?= htmlspecialchars($datos->product_id) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- JavaScript para Rellenar el Formulario de Edición -->
    <script>
        function fillEditForm(id, name, description, price, categoryId, stock) {
            document.getElementById('editProductId').value   = id;
            document.getElementById('editNombre').value      = name;
            document.getElementById('editDescripcion').value = description;
            document.getElementById('editPrecio').value      = price;
            document.getElementById('editCategoria').value   = categoryId;
            document.getElementById('editStock').value       = stock;
        }

        function confirmDelete(productId) {
            if (confirm("¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.")) {
                window.location.href = `controlador/eliminarProducto.php?id=${productId}`;
            }
        }
    </script>
</div>
<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>
