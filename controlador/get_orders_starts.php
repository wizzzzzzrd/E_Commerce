<?php
require '../modelo/conexion.php';

header('Content-Type: application/json');

// Recuperar datos de pedidos agrupados por fecha
$sql = "SELECT DATE(order_date) as date, COUNT(*) as count FROM orders GROUP BY DATE(order_date)";
$result = $conexion->query($sql);

$dates = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['date'];
    $counts[] = $row['count'];
}

echo json_encode([
    'dates' => $dates,
    'counts' => $counts
]);

$conexion->close();
?>
