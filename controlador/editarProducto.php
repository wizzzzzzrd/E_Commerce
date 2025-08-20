<?php
require '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../Cimagenes.php?msg=error");
    exit();
}

$productId          = intval($_POST['product_id']);
$productName        = trim($_POST['product_name']);
$productDescription = trim($_POST['product_description']);
$productPrice       = floatval($_POST['product_price']);
$categoryId         = intval($_POST['category_id']);
$productStock       = intval($_POST['product_stock']);
$directorio         = "../archivos/";

$extPermitidas = ['jpg','jpeg','png','svg'];

// 1) Procesar primera imagen si se sube una nueva
$imagePath1 = null;
if (!empty($_FILES['product_image']['name'])) {
    $ext1 = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
    if (in_array($ext1, $extPermitidas)) {
        $target1 = $directorio . $productId . "." . $ext1;
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target1)) {
            $imagePath1 = "archivos/{$productId}.{$ext1}";
        }
    } else {
        header("Location: ../Cimagenes.php?msg=warning");
        exit();
    }
}

// 2) Procesar segunda imagen si se sube una nueva
$imagePath2 = null;
if (!empty($_FILES['product_image2']['name'])) {
    $ext2 = strtolower(pathinfo($_FILES['product_image2']['name'], PATHINFO_EXTENSION));
    if (in_array($ext2, $extPermitidas)) {
        $target2 = $directorio . $productId . "_2." . $ext2;
        if (move_uploaded_file($_FILES['product_image2']['tmp_name'], $target2)) {
            $imagePath2 = "archivos/{$productId}_2.{$ext2}";
        }
    } else {
        header("Location: ../Cimagenes.php?msg=warning");
        exit();
    }
}

// 3) Si no subió nuevas imágenes, obtenemos las rutas existentes
if (empty($imagePath1)) {
    $q = $conexion->prepare("SELECT product_image FROM products WHERE product_id = ?");
    $q->bind_param("i", $productId);
    $q->execute();
    $q->bind_result($imagePath1);
    $q->fetch();
    $q->close();
}
if (empty($imagePath2)) {
    $q = $conexion->prepare("SELECT product_image2 FROM products WHERE product_id = ?");
    $q->bind_param("i", $productId);
    $q->execute();
    $q->bind_result($imagePath2);
    $q->fetch();
    $q->close();
}

// 4) Determinar actions_enabled según el stock: 1 si stock > 0, 0 si stock <= 0
$actions_enabled = ($productStock > 0) ? 1 : 0;

// 5) Actualizar registro con todos los campos (incluyendo actions_enabled)
$sql = "
    UPDATE products SET
        product_name        = ?,
        product_description = ?,
        product_price       = ?,
        category_id         = ?,
        product_image       = ?,
        product_image2      = ?,
        actions_enabled     = ?,
        product_stock       = ?
    WHERE product_id = ?
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param(
    "ssdissiii",
    $productName,
    $productDescription,
    $productPrice,
    $categoryId,
    $imagePath1,
    $imagePath2,
    $actions_enabled,
    $productStock,
    $productId
);

if ($stmt->execute()) {
    header("Location: ../Cimagenes.php?msg=success");
} else {
    header("Location: ../Cimagenes.php?msg=error");
}

$stmt->close();
$conexion->close();
exit();
?>
