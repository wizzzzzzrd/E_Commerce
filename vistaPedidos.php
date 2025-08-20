<!DOCTYPE html>
<html lang="es">
<?php include 'fragmentos/headerAdmin.php'; ?>

<div class="container mt-4">
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark font-title">Vista de Pedidos</h1>

    <!-- Formulario de filtro por fecha -->
    <form method="GET" class="mb-4 d-flex">
        <div class="row flex-grow-1">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_date" class="form-label font-body">Fecha de Inicio</label>
                    <input type="date" id="start_date" name="start_date" class="form-control font-body" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_date" class="form-label font-body">Fecha de Fin</label>
                    <input type="date" id="end_date" name="end_date" class="form-control font-body" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2 font-subtitle">Filtrar</button>
                <a href="vistaPedidos.php" class="btn btn-secondary font-subtitle">Mostrar Todas las Fechas</a>
            </div>
        </div>
    </form>

    <!-- Tabla responsive -->
    <div class="table-responsive container mt-4">
        <table class="table table-striped table-bordered font-body">
            <thead>
                <tr>
                    <th class="font-subtitle">ID de Pedido</th>
                    <th class="font-subtitle">Nombre</th>
                    <th class="font-subtitle">Email</th>
                    <th class="font-subtitle">Teléfono</th>
                    <th class="font-subtitle">Número de Tarjeta</th>
                    <th class="font-subtitle">Total</th>
                    <th class="font-subtitle">Fecha de Pedido</th>
                    <th class="font-subtitle">Estado</th>
                    <th class="font-subtitle">Metodo de Entrega</th>
                    <th class="font-subtitle">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión

                // Obtener los parámetros de fecha del formulario
                $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                // Construir la consulta SQL con el filtro por fecha
                $query = "SELECT * FROM orders";
                if ($startDate && $endDate) {
                    $query .= " WHERE order_date BETWEEN ? AND ?";
                }

                $stmt = $conexion->prepare($query);
                if ($startDate && $endDate) {
                    $stmt->bind_param("ss", $startDate, $endDate);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['num_card']}</td>";
                    echo "<td>{$row['total']}</td>";
                    echo "<td>{$row['order_date']}</td>";
                    echo "<td>{$row['status_venta']}</td>";
                    echo "<td>{$row['delivery_method']}</td>";

                    if ($row['status_venta'] == 'no pagado') {
                        echo "<td><button class='btn btn-success update-status font-subtitle' data-id='{$row['id']}'>Marcar como Pagado</button></td>";
                    } else {
                        echo "<td>--</td>";
                    }

                    echo "</tr>";
                }

                $result->free();
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Incluye jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    $(document).ready(function() {
        // Delegación para que funcione aunque haya filas dinámicas
        $(document).on('click', '.update-status', function() {
            var button = $(this);
            var orderId = button.data('id');

            // Deshabilitar el botón para evitar múltiples clics
            button.prop('disabled', true);

            // Usamos fetch en lugar de $.ajax porque la versión slim de jQuery no tiene ajax
            var formData = new FormData();
            formData.append('order_id', orderId);

            fetch('controlador/update_status.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(function(response) { return response.text(); })
            .then(function(text) {
                text = (text || '').toString().trim();
                if (text === 'success') {
                    alert('Estado actualizado correctamente.');
                    var row = button.closest('tr');
                    // La columna "Estado" es la 7 (0-based)
                    row.find('td').eq(7).text('pagado');
                    // Reemplazamos la columna "Acciones" (índice 9) por --
                    row.find('td').eq(9).html('--');
                    button.remove();
                } else {
                    console.error('Respuesta inesperada del servidor:', text);
                    alert('Error al actualizar el estado.');
                    button.prop('disabled', false);
                }
            })
            .catch(function(err) {
                console.error('Fetch error:', err);
                alert('Hubo un problema al actualizar el estado.');
                button.prop('disabled', false);
            });
        });
    });
</script>

</div>

<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>
