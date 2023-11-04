<a href="IntermedioCuota.php">Volver</a>
<?php
// Establece la conexión a la base de datos (asegúrate de tener configurada la conexión)
require '../../conexion.php';
$conexion = conectar();

// Verifica la conexión
if (!$conexion) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Variables para los filtros de fechas y método de pago
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : "";
$fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : "";
$metodoPago = isset($_GET['metodo_pago']) ? $_GET['metodo_pago'] : "";

// Consulta SQL para obtener los pagos con detalles de cuota, padre, y alumno, incluyendo el nombre del archivo adjunto
$sql = "SELECT
            pago.id,
            pago.montoPago,
            pago.fecha,
            cuotas.mes,
            padre.correo AS correo_padre,
            alumno.nombre AS nombre_alumno,
            alumno.legajo,
            pago.comprobante AS nombre_archivo,
            pago.metodo AS metodoPago
        FROM pago
        JOIN cuotas ON pago.idCuota = cuotas.id
        JOIN alumno ON cuotas.idAlumno = alumno.id
        JOIN padre ON alumno.idPadre = padre.id
        WHERE (pago.fecha >= '$fechaInicio' AND pago.fecha <= '$fechaFin')";

if (!empty($metodoPago)) {
    $sql .= " AND pago.metodo = '$metodoPago'";
}

$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    // Inicializa un arreglo para almacenar los pagos
    $pagos = array();

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $pagos[] = $fila;
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
    <title>Tabla de Pagos</title>
</head>
<body>
    <h1>Tabla de Pagos</h1>

    <form method="get">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?= $fechaInicio ?>">

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" value="<?= $fechaFin ?>">

        <label for="metodo_pago">Método de Pago:</label>
        <select name="metodo_pago" id="metodo_pago">
            <option value="">Todos</option>
            <option value="Efectivo" <?= ($metodoPago == 'Efectivo') ? 'selected' : '' ?>>Efectivo</option>
            <option value="Crédito" <?= ($metodoPago == 'Crédito') ? 'selected' : '' ?>>Crédito</option>
            <option value="Débito" <?= ($metodoPago == 'Débito') ? 'selected' : '' ?>>Débito</option>
        </select>

        <input type="submit" value="Filtrar">
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>Correo del Padre</th>
                <th>Nombre del Alumno</th>
                <th>Legajo del Alumno</th>
                <th>Monto del Pago</th>
                <th>Método de Pago</th>
                <th>Fecha</th>
                <th>Mes</th>
                <th>Comprobante</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $pago): ?>
                <tr>
                    <td><?= $pago['correo_padre'] ?></td>
                    <td><?= $pago['nombre_alumno'] ?></td>
                    <td><?= $pago['legajo'] ?></td>
                    <td><?= $pago['montoPago'] ?></td>
                    <td><?= $pago['metodoPago'] ?></td>
                    <td><?= $pago['fecha'] ?></td>
                    <td><?= $pago['mes'] ?></td>
                    <td><a href="../../Comprobantes/<?= $pago['nombre_archivo'] ?>" download><?= $pago['nombre_archivo'] ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
