<!DOCTYPE html>
<html lang="es">
<?php include 'fragmentos/header.php'; ?>


<body>
    <br><br>
    <div class="container mt-5">
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 bg-white p-5 rounded-4 shadow-lg" style="width: 100%; max-width: 400px; margin-top:5%; margin-bottom:5%;">
                <!-- Título principal -->
                <h2 class="text-center mb-4 text-dark font-title">Iniciar Sesión</h2>
                <!-- Texto muy pequeño debajo -->
                <p class="text-center text-muted font-body" style="font-size: 0.75rem;">
                    Introduce correctamente tus credenciales, para ver el panel de administración. </p>
                <!-- Mensajes de alerta -->
                <?php if (isset($_GET['msg'])) : ?>
                    <?php if ($_GET['msg'] == 'error') : ?>
                        <div class="alert alert-danger alert-dismissible fade show font-body" role="alert">
                            Nombre de usuario o contraseña incorrectos.
                        </div>
                    <?php elseif ($_GET['msg'] == 'empty') : ?>
                        <div class="alert alert-warning alert-dismissible fade show font-body" role="alert">
                            Por favor, complete todos los campos.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Formulario de inicio de sesión -->
                <form action="controlador/login.php" method="POST">
                    <!-- Nombre de usuario -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control font-body" id="username" name="username" placeholder="Nombre de usuario" required>
                        <label for="username" class="font-body">Nombre de Usuario</label>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control font-body" id="password" name="password" placeholder="Contraseña" required>
                        <label for="password" class="font-body">Contraseña</label>
                    </div>

                    <!-- Botón de inicio de sesión -->
                    <button type="submit" class="btn btn-dark w-100 font-subtitle">Iniciar Sesión</button>
                </form>

            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <?php include 'fragmentos/footer.php'; ?>
