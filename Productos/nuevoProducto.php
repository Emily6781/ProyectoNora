<?php
    $nombre_producto = $_POST['nombre'];
    $precio_producto = floatval($_POST['precio']);
    $tipo_id = intval($_POST['tipo_id']);
    
    // Iniciar transacción
    $conn->begin_transaction();
    
    try {
        // Insertar el producto en la tabla 'productos'
        $stmt_producto = $conn->prepare("INSERT INTO productos (Nombre, Precio, Tipo_ID) VALUES (?, ?, ?)");
        $stmt_producto->bind_param("sdi", $nombre_producto, $precio_producto, $tipo_id);
        $stmt_producto->execute();
        
        // Obtener el ID del producto recién insertado
        $producto_id = $stmt_producto->insert_id;
        $stmt_producto->close();

        // Insertar la imagen en la tabla 'imagenes'
        $nombre_imagen = $_FILES['imagen']['name'];
        $tipo_imagen = $_FILES['imagen']['type'];
        $datos_imagen = file_get_contents($_FILES['imagen']['tmp_name']);

        $stmt_imagen = $conn->prepare("INSERT INTO imagenes (nombre, tipo, datos, producto_id) VALUES (?, ?, ?, ?)");
        $stmt_imagen->bind_param("sssi", $nombre_imagen, $tipo_imagen, $datos_imagen, $producto_id);
        $stmt_imagen->execute();
        $stmt_imagen->close();

        // Confirmar transacción
        $conn->commit();
        $mensaje = "Producto y su imagen se han registrado con éxito.";
    } catch (Exception $e) {
        // En caso de error, deshacer cambios
        $conn->rollback();
        $mensaje = "Error al registrar el producto y la imagen: " . $e->getMessage();
    }
?>