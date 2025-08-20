<?php
require '../modelo/conexion.php'; // Asegúrate de usar la ruta correcta

// Agregar el usuario administrador
$username = 'admin';
$password = '123456'; // Contraseña en texto claro
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insertar el usuario administrador en la base de datos
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "Administrador agregado exitosamente.";
} else {
    echo "Error al agregar administrador: " . $conexion->error;
}

$stmt->close();
$conexion->close();
?>
