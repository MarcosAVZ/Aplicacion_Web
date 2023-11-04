<a href="intermedioCuotas.php">Volver</a>
<?php
// Conexión a la base de datos (asegúrate de tener configurada la conexión)
require '../../conexion.php';
$conexion = conectar();
$id_padre = 1; // Supongamos que $id_padre contiene el ID del padre actual

// Verifica la conexión
if (!$conexion) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Consulta SQL para actualizar el estado de las cuotas
$sql = "UPDATE cuotas AS c
        SET c.estado = 'pagado'
        WHERE 
            (SELECT SUM(p.montoPago) FROM pago AS p WHERE p.idCuota = c.id) >= c.monto";

if (mysqli_query($conexion, $sql)) {
    echo "Estado de las cuotas actualizado correctamente.";
} else {
    echo "Error al actualizar el estado de las cuotas: " . mysqli_error($conexion);
}

// Consulta SQL para obtener las cuotas pendientes del padre con monto pendiente
$sql = "SELECT c.id, c.mes, (c.monto - IFNULL(SUM(p.montoPago), 0)) AS monto_pendiente
        FROM cuotas AS c
        LEFT JOIN pago AS p ON c.id = p.idCuota
        WHERE c.id_padre = $id_padre AND c.estado = 'pendiente'
        GROUP BY c.id, c.mes, c.monto";

// Ejecuta la consulta y obtiene los resultados
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    // Inicializa un arreglo para almacenar las cuotas
    $cuotas = array();

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $cuotas[] = $fila;
    }
} else {
    die("Error al ejecutar la consulta: " . mysqli_error($conexion));
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pago de Cuotas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>
</head>
<body>
    <a href="procesar_pago.php">Realizar Pago</a>
    <h1>Cuotas Pendientes</h1>
    <table>
        <tr>
            <th>Mes</th>
            <th>Monto Pendiente</th>
        </tr>
        <?php
            foreach ($cuotas as $cuota) {
                echo '<tr>';
                echo '<td>' . $cuota['mes'] . '</td>';
                echo '<td>$' . $cuota['monto_pendiente'] . '</td>';
                echo '</tr>';
            }
        ?>
    </table>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>Formulario de Pago</h2>
            <form id="formulario-pago">
                <label for="monto">Monto:</label>
                <input type="text" id="monto" name="monto" required>
                <input type="hidden" id="cuotaId" name="cuotaId" value="">
                <input type...  <!-- Resto del formulario -->
            </form>
        </div>
    </div>
</html>
