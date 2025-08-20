<?php
require 'modelo/conexion.php';

$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';

// Consulta SQL para recuperar productos
$query = "SELECT * FROM products";
if ($category_id) {
    $query .= " WHERE category_id = ?";
}

$stmt = $conexion->prepare($query);

if ($category_id) {
    $stmt->bind_param("i", $category_id);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div class='col-sm-6 col-md-4 col-lg-3'>";
    echo "<div class='card h-100 border-0 shadow-sm'>";
    echo "<img src='{$row['product_image']}' class='card-img-top' alt='{$row['product_name']}'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>{$row['product_name']}</h5>";
    echo "<p class='card-text'>{$row['product_description']}</p>";
    echo "<p class='card-price'>$ {$row['product_price']}</p>";
    echo "</div></div></div>";
}

$result->free();
$conexion->close();
?>
