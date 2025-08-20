<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<?php include 'fragmentos/headerAdmin.php'; ?>

<div class="container mt-4">
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark font-title">Detalles del Pedido</h1>

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
                <a href="vistaPedidosDetail.php" class="btn btn-secondary font-subtitle">Mostrar Todas las Fechas</a>
            </div>
        </div>
    </form>

    <!-- Tabla responsive -->
    <div class="table-responsive container mt-4">
        <table class="table table-striped table-bordered font-body">
            <thead>
                <tr>
                    <th class="font-subtitle">ID del Detalle</th>
                    <th class="font-subtitle">ID de Pedido</th>
                    <th class="font-subtitle">ID del Producto</th>
                    <th class="font-subtitle">Nombre del Producto</th>
                    <th class="font-subtitle">Cantidad</th>
                    <th class="font-subtitle">Precio</th>
                    <th class="font-subtitle">Total</th>
                    <th class="font-subtitle">Total por Pedido</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión

                // Obtener los parámetros de fecha del formulario
                $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                // Construir la consulta SQL con el filtro por fecha
                $query = "SELECT * FROM order_details";
                if ($startDate && $endDate) {
                    $query .= " JOIN orders ON order_details.order_id = orders.id WHERE orders.order_date BETWEEN ? AND ?";
                }

                $stmt = $conexion->prepare($query);
                if ($startDate && $endDate) {
                    $stmt->bind_param("ss", $startDate, $endDate);
                }

                $stmt->execute();
                $details_result = $stmt->get_result();

                // Array para acumular los totales por ID de pedido
                $order_totals = [];
                $order_counts = [];

                while ($detail_row = $details_result->fetch_assoc()) {
                    // Acumular el total por ID de pedido
                    if (!isset($order_totals[$detail_row['order_id']])) {
                        $order_totals[$detail_row['order_id']] = 0;
                        $order_counts[$detail_row['order_id']] = 0;
                    }
                    $order_totals[$detail_row['order_id']] += $detail_row['total'];
                    $order_counts[$detail_row['order_id']]++;
                }

                // Reiniciar el puntero del resultado para recorrerlo nuevamente
                $details_result->data_seek(0);

                // Array para marcar si ya se mostró el total por pedido
                $shown_orders = [];

                while ($detail_row = $details_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$detail_row['detail_id']}</td>";
                    echo "<td>{$detail_row['order_id']}</td>";
                    echo "<td>{$detail_row['product_id']}</td>";
                    echo "<td>{$detail_row['product_name']}</td>";
                    echo "<td>{$detail_row['quantity']}</td>";
                    echo "<td>{$detail_row['price']}</td>";
                    echo "<td>{$detail_row['total']}</td>";

                    // Mostrar el total acumulado por pedido solo en la primera fila de cada ID de pedido
                    if (!isset($shown_orders[$detail_row['order_id']])) {
                        echo "<td rowspan='{$order_counts[$detail_row['order_id']]}' class='align-middle font-body'>" . number_format($order_totals[$detail_row['order_id']], 2) . "</td>";
                        $shown_orders[$detail_row['order_id']] = true;
                    } else {
                        echo "<td class='font-body'></td>";
                    }

                    echo "</tr>";
                }

                $details_result->free();
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Incluye jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</div>

<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>
