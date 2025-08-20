<?php
require '../modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión

if (empty($_POST["btnregistrar"])) {
    header('Location: ../Cimagenes.php?msg=error');
    exit();
}

$directorio = "../archivos/";

// Datos de la primera imagen
$img1      = $_FILES["product_image"]["tmp_name"];
$nombre1   = $_FILES["product_image"]["name"];
$tipo1     = strtolower(pathinfo($nombre1, PATHINFO_EXTENSION));

// Datos de la segunda imagen
$img2      = $_FILES["product_image2"]["tmp_name"];
$nombre2   = $_FILES["product_image2"]["name"];
$tipo2     = strtolower(pathinfo($nombre2, PATHINFO_EXTENSION));

// Validar extensiones
$extPermitidas = ['jpg','jpeg','png','svg'];
if (!in_array($tipo1, $extPermitidas) || !in_array($tipo2, $extPermitidas)) {
    echo "<div class='alert alert-warning'>
            Formato NO COMPATIBLE, Por favor, sube imágenes en formato .JPG, .JPEG, .PNG, o .SVG
          </div>";
    exit();
}

// Obtener datos del formulario
$nombre       = trim($_POST["product_name"]);
$descripcion  = trim($_POST["product_description"]);
$precio       = floatval($_POST["product_price"]);
$categoria_id = intval($_POST["category_id"]);
$stock        = intval($_POST["product_stock"]);

// Verificar si la categoría existe
$categoriaCheck = $conexion->prepare("SELECT COUNT(*) FROM categories WHERE category_id = ?");
$categoriaCheck->bind_param("i", $categoria_id);
$categoriaCheck->execute();
$categoriaCheck->bind_result($count);
$categoriaCheck->fetch();
$categoriaCheck->close();

if ($count === 0) {
    echo "<div class='alert alert-warning'>
            La categoría seleccionada no existe. Por favor, selecciona una categoría válida.
          </div>";
    exit();
}

// Determinar actions_enabled según stock: 1 si stock > 0, 0 si stock <= 0
$actions_enabled = ($stock > 0) ? 1 : 0;

// Insertar el producto (sin las rutas de imagen aún), ahora incluyendo actions_enabled
$stmt = $conexion->prepare("
    INSERT INTO products 
        (product_name, product_description, product_price, category_id, product_stock, actions_enabled) 
    VALUES 
        (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $categoria_id, $stock, $actions_enabled);

if (!$stmt->execute()) {
    header('Location: ../Cimagenes.php?msg=error');
    exit();
}

$idRegistro = $conexion->insert_id;
$stmt->close();

// Construir y mover ambas imágenes
$ruta1 = $directorio . $idRegistro . "." . $tipo1;
$ruta2 = $directorio . $idRegistro . "_2." . $tipo2;

$success1 = move_uploaded_file($img1, $ruta1);
$success2 = move_uploaded_file($img2, $ruta2);

$rutaEnBD1 = $success1 ? "archivos/{$idRegistro}.{$tipo1}" : null;
$rutaEnBD2 = $success2 ? "archivos/{$idRegistro}_2.{$tipo2}" : null;

// Actualizar las rutas en la BD
$update = $conexion->prepare("
    UPDATE products
    SET product_image  = ?,
        product_image2 = ?
    WHERE product_id = ?
");
$update->bind_param("ssi", $rutaEnBD1, $rutaEnBD2, $idRegistro);

if ($update->execute()) {
    header('Location: ../Cimagenes.php?msg=success');
} else {
    header('Location: ../Cimagenes.php?msg=warning');
}
$update->close();
$conexion->close();
exit();
?>
<script>
    history.replaceState(null, null, location.pathname)
</script>
