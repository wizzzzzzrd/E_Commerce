<?php
require '../modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];

    // Verifica si se recibe el ID correctamente
    error_log("Received order_id: " . $order_id);

    // Prepara la consulta SQL para actualizar el estado del pedido
    $stmt = $conexion->prepare("UPDATE orders SET status_venta = 'pagado' WHERE id = ? AND status_venta = 'no pagado'");
    $stmt->bind_param("i", $order_id);

    // Ejecuta la consulta y verifica el resultado
    if ($stmt->execute()) {
        error_log("Update successful for order_id: " . $order_id);
        echo "success";
    } else {
        error_log("Update failed for order_id: " . $order_id);
        echo "error";
    }

    // Cierra la declaración y la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo "No se ha enviado ningún dato.";
}
?>
