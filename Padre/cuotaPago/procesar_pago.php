<a href="pagar_cuota.php">Volver</a>
<?php
// Conexión a la base de datos
require '../../conexion.php';
$conn = conectar();

// Obtener los meses pendientes de cuotas relacionadas al ID del padre
$idPadre = 1;
$query = "SELECT DISTINCT cuotas.mes
          FROM cuotas
          WHERE cuotas.id_Padre = $idPadre
            AND cuotas.estado = 'pendiente'";
$result = mysqli_query($conn, $query);
?>

<form action="procesar_pago.php" method="post" enctype="multipart/form-data">
    <label>Monto Pago:</label>
    <input type="text" name="montoPago"><br>

    <label>Mes:</label>
    <select name="mesSeleccionado">
        <?php
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='{$row['mes']}'>{$row['mes']}</option>";
        }
        ?>
    </select><br>

    <label>Nro Comprobante:</label>
    <input type="text" name="nroComprobante"><br>

    <label>Comprobante:</label>
    <input type="file" name="comprobante"><br>

    <label>Método de Pago:</label>
    <select name="metodoPago">
        <option value="Efectivo">Efectivo</option>
        <option value="Crédito">Crédito</option>
        <option value="Débito">Débito</option>
    </select><br>

    <input type="submit" value="Guardar">
</form>

<?php

// Verifica la conexión
if (!$conn) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los valores del formulario
    $montoPago = $_POST["montoPago"];
    $mesSeleccionado = $_POST["mesSeleccionado"];
    $nroComprobante = $_POST["nroComprobante"];
    $metodoPago = $_POST["metodoPago"]; // Agregamos esta línea para obtener el método de pago

    // Subir el archivo del comprobante
    $comprobanteDir = '../../Comprobantes/'; // Establece la ruta deseada
    $comprobanteNombre = $_FILES['comprobante']['name'];
    $comprobanteTemp = $_FILES['comprobante']['tmp_name'];
    $comprobantePath = $comprobanteDir . $comprobanteNombre;

    if (move_uploaded_file($comprobanteTemp, $comprobantePath)) {
        // Consulta para insertar en la tabla pago
        $query = "INSERT INTO pago (montoPago, fecha, idCuota, nroComprobante, comprobante, metodo) VALUES (?, NOW(), (SELECT id FROM cuotas WHERE mes = ? AND id_Padre = ?), ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        $idPadre = 1; // Supongamos que $idPadre contiene el ID del padre actual

        // Vincula los parámetros
        mysqli_stmt_bind_param($stmt, "ssisss", $montoPago, $mesSeleccionado, $idPadre, $nroComprobante, $comprobanteNombre, $metodoPago); // Agregamos $metodoPago

        // Ejecuta la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "Pago registrado con éxito.";
        } else {
            echo "Error al registrar el pago: " . mysqli_error($conn);
        }

        // Cierra la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al subir el archivo del comprobante.";
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
