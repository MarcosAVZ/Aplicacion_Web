<!DOCTYPE html>
<html>
<head>
    <title>Cuotas Mensuales</title>
</head>
<body>
    <a href="../padre.php">Volver</a>
    <h1>Cuotas Mensuales</h1>
<?php

    // Supongamos que $id_padre contiene el ID del padre actual
    require '../../conexion.php';

    $conexion = conectar();
    $id_padre = 1;
    // Verifica la conexión
    if (!$conexion) {
        die("La conexión a la base de datos falló: " . mysqli_connect_error());
    }

    // Consulta SQL para obtener las cuotas del padre actual
    $sql = "SELECT mes, año, monto, estado FROM cuotas WHERE id_padre = $id_padre";

    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        // Muestra los resultados en una tabla
        echo "<table>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Monto</th>
                    <th>Estado</th>
                </tr>";

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>" . $fila["mes"] . "</td>
                    <td>" . $fila["año"] . "</td>
                    <td>$" . $fila["monto"] . "</td>
                    <td>" . $fila["estado"] . "</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron cuotas mensuales para este padre.";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
?>

</body>
</html>
Crea un archivo PHP ("pagar_cuota.php") para procesar el pago de una cuota:
php
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuota_id = $_POST["cuota_id"];
    
    // Aquí debes realizar la lógica para marcar la cuota como "pagada" en la base de datos.
    
    // Ejemplo de actualización simple (no seguro):
    // Actualiza el estado de la cuota en la base de datos a "pagado".
    
    // Redirige de nuevo a la página de cuotas después de realizar el pago.
    header("Location: cuotas.php");
    exit();
}
?>
Este es un ejemplo básico para la interfaz de usuario. Debes adaptarlo y mejorar la seguridad según tus necesidades específicas. Además, debes agregar la lógica de validación de inicio de sesión y de pago que interactúe con tu base de datos.





