<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
    <?php include 'fragmentos/headerAdmin.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center display-4 font-title mb-4 text-dark">Panel de Administrador</h1>

        <!-- Sección de bienvenida -->
        <div class="alert alert-info font-body" role="alert">
            ¡Bienvenido al panel de administración! Desde aquí podrás gestionar todas las funciones del e-commerce.
        </div>

        <!-- Sección de resumen -->
        <div class="row mt-4 font-body">
            <div class="col-md-4 mb-4">
                <div class="card border-0">
                    <img src="imagenes/product_admin.svg" class="card-img-top" alt="Gestionar Productos">
                    <div class="card-body">
                        <h5 class="card-title font-subtitle">Gestionar Productos</h5>
                        <p class="card-text font-body">Añade, edita o elimina productos del catálogo. Mantén actualizado el inventario para ofrecer la mejor experiencia a tus clientes.</p>
                        <a href="Cimagenes.php" class="btn btn-primary font-subtitle">Ir a Productos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0">
                    <img src="imagenes/categories_admin.svg" class="card-img-top" alt="Gestionar Categorías">
                    <div class="card-body">
                        <h5 class="card-title font-subtitle">Gestionar Categorías</h5>
                        <p class="card-text font-body">Organiza los productos en categorías. Facilita la navegación y búsqueda de productos para tus clientes.</p>
                        <a href="Ccategorias.php" class="btn btn-primary font-subtitle">Ir a Categorías</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0">
                    <img src="imagenes/orders_admin.svg" class="card-img-top" alt="Ver Pedidos">
                    <div class="card-body">
                        <h5 class="card-title font-subtitle">Ver Pedidos</h5>
                        <p class="card-text font-body">Consulta y gestiona los pedidos realizados por los clientes. Asegúrate de que todo esté en orden y realiza un seguimiento efectivo.</p>
                        <a href="vistaPedidos.php" class="btn btn-primary font-subtitle">Ir a Pedidos</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Sección de estadísticas -->
        <div class="row mt-4 font-body">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title font-subtitle">Estadísticas del Sitio</h5>
                        <p class="card-text font-body">Aquí podrás ver un resumen de las estadísticas del sitio, como el número de pedidos realizados por fecha.</p>
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Incluye jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Script para la gráfica -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('ordersChart').getContext('2d');

                // Recuperar datos del servidor para la gráfica
                fetch('controlador/get_orders_starts.php')
                    .then(response => response.json())
                    .then(data => {
                        var labels = data.dates;
                        var values = data.counts;

                        var ordersChart = new Chart(ctx, {
                            type: 'bar', // Tipo de gráfica (puedes cambiarlo a 'line' si prefieres)
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Pedidos por Fecha',
                                    data: values,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error al recuperar datos para la gráfica:', error));
            });
        </script>

    </div>
    <!-- FOOTER -->
    <?php include 'fragmentos/footer.php'; ?>
