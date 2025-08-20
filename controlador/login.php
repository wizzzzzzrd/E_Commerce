<?php
require '../modelo/conexion.php'; // Asegúrate de usar la ruta correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        header('Location: ../login.php?msg=empty');
        exit();
    }

    // Buscar usuario en la base de datos
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verificar contraseña
        if (password_verify($password, $user['password'])) {
            // Iniciar sesión
            session_start();
            $_SESSION['admin'] = $user['username'];
            header('Location: ../admin_dashboard.php'); // Redirigir a la página de administrador
        } else {
            header('Location: ../login.php?msg=error');
        }
    } else {
        header('Location: ../login.php?msg=error');
    }

    $stmt->close();
    $conexion->close();
}
?>
