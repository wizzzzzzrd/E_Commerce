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
    <h1 class="text-center display-4 font-weight-bold mb-4 text-dark font-title">Detalles de Envíos</h1>

    <!-- Filtro por fecha -->
    <form method="GET" class="mb-4 d-flex">
        <div class="row flex-grow-1">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_date" class="form-label font-body">Fecha de Inicio</label>
                    <input type="date" id="start_date" name="start_date" class="form-control font-body"
                        value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_date" class="form-label font-body">Fecha de Fin</label>
                    <input type="date" id="end_date" name="end_date" class="form-control font-body"
                        value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2 font-subtitle">Filtrar</button>
                <a href="vistaEnvios.php" class="btn btn-secondary font-subtitle">Mostrar Todas las Fechas</a>
            </div>
        </div>
    </form>

    <!-- Tabla de envíos -->
    <div class="table-responsive container mt-4">
        <table class="table table-striped table-bordered font-body">
            <thead>
                <tr>
                    <th class="font-subtitle">ID Pedido</th>
                    <th class="font-subtitle">Nombre Completo</th>
                    <th class="font-subtitle">Email</th>
                    <th class="font-subtitle">Teléfono</th>
                    <th class="font-subtitle">Dirección</th>
                    <th class="font-subtitle">Dirección 2</th>
                    <th class="font-subtitle">Ciudad</th>
                    <th class="font-subtitle">Estado</th>
                    <th class="font-subtitle">C.P.</th>
                    <th class="font-subtitle">País</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'modelo/conexion.php';

                $startDate = $_GET['start_date'] ?? '';
                $endDate = $_GET['end_date'] ?? '';

                // Consulta con join para traer el shipping_details según fecha de orders
                $query = "
                    SELECT s.order_id, s.full_name, s.email, s.phone, s.address, s.address2, s.city, s.state, s.zip, s.country
                    FROM shipping_details s
                    INNER JOIN orders o ON s.order_id = o.id
                ";

                if ($startDate && $endDate) {
                    $query .= " WHERE o.order_date BETWEEN ? AND ?";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("ss", $startDate, $endDate);
                } else {
                    $stmt = $conexion->prepare($query);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td>{$row['full_name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td>{$row['address2']}</td>";
                    echo "<td>{$row['city']}</td>";
                    echo "<td>{$row['state']}</td>";
                    echo "<td>{$row['zip']}</td>";
                    echo "<td>{$row['country']}</td>";
                    echo "</tr>";
                }

                $stmt->close();
                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</div>

<!-- FOOTER -->
<?php include 'fragmentos/footer.php'; ?>
