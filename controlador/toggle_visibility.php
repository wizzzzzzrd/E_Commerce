<?php
// controlador/toggle_visibility.php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'msg' => 'Método no permitido']);
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
if ($product_id <= 0) {
    echo json_encode(['success' => false, 'msg' => 'product_id inválido']);
    exit;
}

// Obtener estado actual y stock
$stmt = $conexion->prepare("SELECT actions_enabled, product_stock FROM products WHERE product_id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $current = (int)$row['actions_enabled'];
    $stock = (int)$row['product_stock'];
    if ($stock <= 0) {
        $new = 0; // forzar disabled si no hay stock
    } else {
        $new = $current ? 0 : 1; // toggle si hay stock
    }
    $stmt->close();

    $upd = $conexion->prepare("UPDATE products SET actions_enabled = ? WHERE product_id = ?");
    $upd->bind_param('ii', $new, $product_id);
    if ($upd->execute()) {
        echo json_encode(['success' => true, 'enabled' => $new]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'No se pudo actualizar']);
    }
    $upd->close();
} else {
    $stmt->close();
    echo json_encode(['success' => false, 'msg' => 'Producto no encontrado']);
}
$conexion->close();
