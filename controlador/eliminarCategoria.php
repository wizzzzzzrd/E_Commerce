<?php
require '../modelo/conexion.php';

if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);
    
    // Intentar eliminar productos relacionados con la categoría
    $sql_delete_products = $conexion->prepare("DELETE FROM products WHERE category_id = ?");
    $sql_delete_products->bind_param("i", $category_id);
    
    if ($sql_delete_products->execute()) {
        // Después de eliminar los productos, intentar eliminar la categoría
        $sql_delete_category = $conexion->prepare("DELETE FROM categories WHERE category_id = ?");
        $sql_delete_category->bind_param("i", $category_id);
        
        if ($sql_delete_category->execute()) {
            header("Location: ../Ccategorias.php?msg=success");
        } else {
            // Error al eliminar la categoría
            header("Location: ../Ccategorias.php?msg=error_category");
        }
    } else {
        // Error al eliminar productos
        header("Location: ../Ccategorias.php?msg=error_products");
    }
} else {
    header("Location: ../Ccategorias.php?msg=error_invalid");
}
?>
