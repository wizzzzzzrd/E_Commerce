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
        <?php elseif ($_GET['msg'] == 'error') : ?>
            <div class="alert alert-danger font-body">ERROR al guardar el registro</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="container">
    <!-- Inicio de Galería interactiva -->
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark font-title">Control de Categorías</h1>

    <!-- Advertencia sobre la eliminación de categorías -->
    <div class="alert alert-warning font-body" role="alert">
        <strong>Advertencia:</strong> Al eliminar una categoría, todos los productos relacionados serán eliminados permanentemente.
    </div>

    <!-- Botón para abrir el modal -->
    <div class="container mt-4">
        <button type="button" class="btn btn-primary font-subtitle" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Nuevo
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-subtitle" id="exampleModalLabel">Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="controlador/registrarCategoria.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre_categoria" class="form-label font-body">Nombre de la Categoría</label>
                            <input type="text" class="form-control font-body" id="nombre_categoria" name="category_name" required>
                        </div>
                        <input type="submit" name="btnregistrarC" value="Registrar" class="form-control btn btn-success font-subtitle">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla responsive -->
    <div class="table-responsive container mt-4">
        <table class="table table-striped table-bordered font-body">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión
                $sql = $conexion->query("SELECT * FROM categories");
                while ($datos = $sql->fetch_object()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($datos->category_id) ?></td>
                        <td><?= htmlspecialchars($datos->category_name) ?></td>
                        <td>
                            <!-- Botones para editar y eliminar -->
                            <a href="#" class="btn btn-warning btn-sm font-subtitle" data-bs-toggle="modal" data-bs-target="#editModal" onclick="fillEditForm(<?= htmlspecialchars($datos->category_id) ?>, '<?= htmlspecialchars($datos->category_name) ?>')">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            <a href="#" class="btn btn-danger btn-sm font-subtitle" onclick="confirmDelete(<?= htmlspecialchars($datos->category_id) ?>)">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para Editar Categoría -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-subtitle" id="editModalLabel">Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="controlador/editarCategoria.php" method="POST">
                        <input type="hidden" id="editCategoryId" name="category_id">
                        <div class="mb-3">
                            <label for="editNombreCategoria" class="form-label font-body">Nombre de la Categoría</label>
                            <input type="text" class="form-control font-body" id="editNombreCategoria" name="category_name" required>
                        </div>
                        <input type="submit" name="btneditar" value="Guardar Cambios" class="form-control btn btn-success font-subtitle">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para Confirmación de Eliminación -->
    <script>
        function confirmDelete(categoryId) {
            if (confirm("¿Estás seguro de que deseas eliminar esta categoría? Esta acción no se puede deshacer y eliminará todos los productos relacionados.")) {
                window.location.href = `controlador/eliminarCategoria.php?id=${categoryId}`;
            }
        }

        function fillEditForm(id, name) {
            document.getElementById('editCategoryId').value = id;
            document.getElementById('editNombreCategoria').value = name;
        }
    </script>
</div>

<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>
