<?php
require '../modelo/conexion.php'; // Asegúrate de usar la ruta correcta para el archivo de conexión

// Verifica si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnregistrarC'])) {
        $categoria_name = $_POST['category_name'];

        // Prepara la consulta SQL para insertar la categoría
        $stmt = $conexion->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $categoria_name);

        // Ejecuta la consulta y verifica el resultado
        if ($stmt->execute()) {
            // Redirige con mensaje de éxito
            header('Location: ../Ccategorias.php?msg=success'); // Redirige al archivo correcto
        } else {
            // Redirige con mensaje de error
            header('Location: ../Ccategorias.php?msg=error'); // Redirige al archivo correcto
        }

        // Cierra la declaración y la conexión
        $stmt->close();
        $conexion->close();
    }
} else {
    echo "No se ha enviado ningún dato.";
}
?>
