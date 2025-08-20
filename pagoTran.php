<!DOCTYPE html>
<html lang="en">
<?php include 'fragmentos/header.php'; ?>

<body>
    <div class="container mt-4">
        <h1 class="text-center display-4 font-weight-bold mb-4 text-dark poppins-light">¡Gracias por tu compra!</h1>
        <p class="text-center small text-muted mb-4">
            Tu pedido ha sido recibido y estamos procesando tu pago.
            <br>
            En breve recibirás un correo con los detalles de tu compra.
        </p>

        <div class="container mt-4 poppins-regular">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-bag fa-5x text-success mb-4"></i>
                    <h5 class="card-title">¡Compra exitosa!</h5>
                    <p class="card-text">
                        Gracias por confiar en nosotros. Si tienes alguna duda, contáctanos a <a href="mailto:soporte@tusitio.com">soporte@tusitio.com</a>.
                    </p>
                    <a href="index.php" class="btn btn-success mt-3">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional, para el funcionamiento de los componentes) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- FOOTER -->
    <?php include 'fragmentos/footer.php'; ?>
</body>
</html>
