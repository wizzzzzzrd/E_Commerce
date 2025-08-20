<?php
header('Content-Type: application/json');
require '../modelo/conexion.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!isset(
    $input['order_id'],
    $input['name'],
    $input['email'],
    $input['total'],
    $input['order_date'],
    $input['status_venta'],
    $input['metodo_pago'],
    $input['delivery_method'],
    $input['cart_items']
)) {
    echo json_encode(['status' => 'missing_data']);
    exit;
}

$order_id       = $input['order_id'];
$name           = $input['name'];
$email          = $input['email'];
$phone          = $input['phone']     ?? '';
$num_card       = $input['num_card']  ?? '';
$total          = (float)$input['total'];
$order_date     = $input['order_date'];
$status_venta   = $input['status_venta'];
$metodo_pago    = $input['metodo_pago'];
$delivery       = $input['delivery_method'];
$cart_items     = $input['cart_items'];
$ship           = $input['shipping_info'] ?? null;

$conexion->begin_transaction();

try {
    // 1) Insertar en orders
    $sql1 = "INSERT INTO orders
        (order_id, name, email, phone, num_card, total, order_date, status_venta, metodo_pago, delivery_method)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $st1 = $conexion->prepare($sql1);
    $st1->bind_param(
        "sssssdssss",
        $order_id,
        $name,
        $email,
        $phone,
        $num_card,
        $total,
        $order_date,
        $status_venta,
        $metodo_pago,
        $delivery
    );
    if (!$st1->execute()) {
        throw new Exception($st1->error);
    }
    $dbOrderId = $conexion->insert_id;
    $st1->close();

    // 2) Insertar en order_details y reducir stock
    $sql2 = "INSERT INTO order_details
        (order_id, product_id, product_name, quantity, price, total)
        VALUES (?, ?, ?, ?, ?, ?)";
    $st2 = $conexion->prepare($sql2);

    $sql_u = "UPDATE products
        SET product_stock = GREATEST(product_stock - ?, 0)
        WHERE product_id = ?";
    $st_u = $conexion->prepare($sql_u);

    foreach ($cart_items as $item) {
        $product_id   = (int)$item['id'];
        $product_name = $item['name'];
        $quantity     = (int)$item['quantity'];
        $price        = (float)$item['price'];
        $item_total   = $price * $quantity;

        $st2->bind_param(
            "iisidd",
            $dbOrderId,
            $product_id,
            $product_name,
            $quantity,
            $price,
            $item_total
        );
        if (!$st2->execute()) {
            throw new Exception($st2->error);
        }

        // Reducir stock
        $st_u->bind_param("ii", $quantity, $product_id);
        if (!$st_u->execute()) {
            throw new Exception($st_u->error);
        }
    }
    $st2->close();
    $st_u->close();

    // 3) Insertar en shipping_details si aplica envío
    if ($delivery === 'envio' && is_array($ship)) {
        $sql3 = "INSERT INTO shipping_details
            (order_id, full_name, email, phone, address, address2, city, state, zip, country)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $st3 = $conexion->prepare($sql3);
        $st3->bind_param(
            "isssssssss",
            $dbOrderId,
            $ship['fullName'],
            $ship['email'],
            $ship['phone'],
            $ship['address'],
            $ship['address2'],
            $ship['city'],
            $ship['state'],
            $ship['zip'],
            $ship['country']
        );
        if (!$st3->execute()) {
            throw new Exception($st3->error);
        }
        $st3->close();
    }

    $conexion->commit();
    echo json_encode(['status' => 'success']);
    exit;

} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}

$conexion->close();
?>
