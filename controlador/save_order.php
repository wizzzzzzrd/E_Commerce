<?php
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Nombre del cliente (balancea entre full_name y name)
    $nombre_cliente = trim(
        $_POST['full_name']
        ?? $_POST['name']
        ?? ''
    );
    $email       = $_POST['email']           ?? '';
    $telefono    = $_POST['phone']           ?? '';
    $num_card    = $_POST['num_card']        ?? '';    // Nuevo campo
    $metodo_pago = $_POST['metodo_pago']     ?? '';
    $delivery    = $_POST['delivery_method'] ?? '';
    $total       = floatval($_POST['total']  ?? 0);
    $order_date  = $_POST['order_date']      ?? date('Y-m-d H:i:s');

    // 2) Estado según método de pago
    $status_venta = (strtolower($metodo_pago) === 'paypal')
                ? 'pagado'
                : 'no pagado';

    // Empezamos transacción
    $conexion->begin_transaction();

    try {
        // 3) Insertar en tabla orders (incluye num_card)
        $sql = "INSERT INTO orders 
                    (name, email, phone, num_card, metodo_pago, delivery_method, total, order_date, status_venta)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            "ssssssdss",
            $nombre_cliente,
            $email,
            $telefono,
            $num_card,
            $metodo_pago,
            $delivery,
            $total,
            $order_date,
            $status_venta
        );
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $order_id = $stmt->insert_id;
        $stmt->close();

        // 4) Insertar detalles del pedido y reducir stock
        $cart_items = json_decode($_POST['cart_items'] ?? '[]', true);
        if (is_array($cart_items) && count($cart_items) > 0) {
            $sql_d = "INSERT INTO order_details 
                        (order_id, product_id, product_name, quantity, price, total)
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_d = $conexion->prepare($sql_d);

            $sql_u = "UPDATE products 
                        SET product_stock = GREATEST(product_stock - ?, 0) 
                      WHERE product_id = ?";
            $stmt_u = $conexion->prepare($sql_u);

            foreach ($cart_items as $it) {
                $pid    = intval($it['id'] ?? 0);
                $name_p = $it['name']      ?? '';
                $qty    = intval($it['quantity'] ?? 0);
                $pr     = floatval($it['price']    ?? 0);
                $sub    = $pr * $qty;

                // Insertar detalle
                $stmt_d->bind_param("iisidd", $order_id, $pid, $name_p, $qty, $pr, $sub);
                if (!$stmt_d->execute()) {
                    throw new Exception($stmt_d->error);
                }

                // Reducir stock
                $stmt_u->bind_param("ii", $qty, $pid);
                if (!$stmt_u->execute()) {
                    throw new Exception($stmt_u->error);
                }
            }
            $stmt_d->close();
            $stmt_u->close();
        }

        // 5) Si es envío, insertar detalles de envío
        if ($delivery === 'envio') {
            $addr1 = $_POST['address']  ?? '';
            $addr2 = $_POST['address2'] ?? '';
            $city  = $_POST['city']     ?? '';
            $state = $_POST['state']    ?? '';
            $zip   = $_POST['zip']      ?? '';
            $cntry = $_POST['country']  ?? '';

            $sql_s = "INSERT INTO shipping_details 
                        (order_id, full_name, email, phone, address, address2, city, state, zip, country)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_s = $conexion->prepare($sql_s);
            $stmt_s->bind_param(
                "isssssssss",
                $order_id,
                $nombre_cliente,
                $email,
                $telefono,
                $addr1,
                $addr2,
                $city,
                $state,
                $zip,
                $cntry
            );
            if (!$stmt_s->execute()) {
                throw new Exception($stmt_s->error);
            }
            $stmt_s->close();
        }

        // 6) Commit y redirección
        $conexion->commit();
        header("Location: ../confirmation.php?status=success");
        exit;
    } catch (Exception $e) {
        $conexion->rollback();
        header("Location: ../cart.php?status=error");
        exit;
    }
}
?>
