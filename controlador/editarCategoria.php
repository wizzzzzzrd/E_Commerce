<?php
require '../modelo/conexion.php';

if (isset($_POST['category_id']) && isset($_POST['category_name'])) {
    $category_id = intval($_POST['category_id']);
    $category_name = trim($_POST['category_name']);

    $sql = $conexion->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
    $sql->bind_param("si", $category_name, $category_id);

    if ($sql->execute()) {
        header("Location: ../Ccategorias.php?msg=success");
    } else {
        header("Location: ../Ccategorias.php?msg=error");
    }
} else {
    header("Location: ../Ccategorias.php?msg=error");
}
?>
