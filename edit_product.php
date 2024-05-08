<?php
include "com.php";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['Nombre'];
    $description = $_POST['Descrpition'];
    $price = floatval($_POST['Price']);

    $sql = "UPDATE producto SET Nombre = ?, Descrpition = ?, Price = ? WHERE id = ?";
    $stmt = $com->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssdi", $name, $description, $price, $id);
        if ($stmt->execute()) {
            header("Location: products_list.php");
            exit();
        } else {
            echo "Error al actualizar el producto.";
        }
    }
}

if ($id > 0) {
    $sql = "SELECT * FROM producto WHERE id = $id";
    $result = $com->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

if (!$product) {
    echo "Producto no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eee6f2;
            padding: 20px;
        }

        h1 {
            color: #333;
            
        }

        .formulario {
            border: 1px solid #ccc;
            background-color: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        .formulario label {
            display: block;
            margin-top: 10px;
            color: #503459;
            margin-bottom: 8px;
        }

        .formulario input {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            
        }

        .formulario button {
            background-color: #503459;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .formulario button:hover {
            background-color: #dac9df;
        }

        .boton-regresar {
            background-color: #503459;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }

        .boton-regresar:hover {
            background-color: #dac9df;
        }
    </style>
</head>
<body>
    <h1>Editar Producto</h1>
    <div class="formulario">
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="Nombre" value="<?php echo htmlspecialchars($product['Nombre']); ?>" required>

            <label>Descripción:</label>
            <input type="text" name="Descrpition" value="<?php echo htmlspecialchars($product['Descrpition']); ?>" required>

            <label>Precio:</label>
            <input type="number" step="0.01" name="Price" value="<?php echo htmlspecialchars($product['Price']); ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>

        <button class="boton-regresar" onclick="history.back();">Regresar</button>
    </div>
</body>
</html>
