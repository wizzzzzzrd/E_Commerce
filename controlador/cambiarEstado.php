<?php
require 'modelo/conexion.php';

$orderId = $_POST['order_id'];

// Cambiar estado de la orden a 'pagado'
$sql = $conexion->prepare("UPDATE orders SET status_venta = 'pagado' WHERE order_id = ?");
$sql->bind_param('i', $orderId);
$sql->execute();

echo json_encode(['success' => true]);
?>
