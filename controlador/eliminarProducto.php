<?php
require '../modelo/conexion.php';

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        header("Location: ../Cimagenes.php?msg=success");
    } else {
        header("Location: ../Cimagenes.php?msg=error");
    }
    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../Cimagenes.php?msg=error");
}
