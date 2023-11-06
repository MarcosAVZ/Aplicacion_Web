<?php
include '../conexion.php';

$conn = conectar();

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar el nuevo monto del formulario
    $nuevoMonto = $_POST["nuevo_monto"];
    
    // Actualizar el monto en la tabla montos_cuota
    $sqlUpdate = "UPDATE montos_cuota SET monto = $nuevoMonto WHERE id = 1";
    
    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Monto actualizado exitosamente.";
    } else {
        echo "Error al actualizar el monto: " . $conn->error;
    }
}

// Obtener el monto actual de la tabla montos_cuota
$sqlSelect = "SELECT monto FROM montos_cuota WHERE id = 1";
$result = $conn->query($sqlSelect);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $montoActual = $row["monto"];
} else {
    $montoActual = 0.00; // Valor predeterminado si no se encuentra un monto
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Modificar Monto de Cuota</title>
</head>

<body>
    <h1>Modificar Monto de Cuota</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nuevo_monto">Nuevo Monto de Cuota:</label>
        <input type="number" step="0.01" name="nuevo_monto" value="<?php echo $montoActual; ?>" required>
        <input type="submit" value="Actualizar Monto">
    </form>
</body>

</html>