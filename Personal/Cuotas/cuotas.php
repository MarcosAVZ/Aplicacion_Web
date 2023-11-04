<a href="IntermedioCuota.php">Volver</a>
<?php
// Establece la conexión a la base de datos (asegúrate de tener configurada la conexión)
require '../../conexion.php';
$conexion = conectar();

// Verifica la conexión
if (!$conexion) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Consulta SQL para obtener los datos de las cuotas
$sql = "SELECT cuotas.mes, alumno.nombre, alumno.legajo, cuotas.monto, cuotas.estado
        FROM cuotas
        INNER JOIN alumno ON cuotas.idAlumno = alumno.id";

// Variables para los filtros
$mesFiltro = isset($_GET['mes']) ? $_GET['mes'] : "";
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : "";
$legajoFiltro = isset($_GET['legajo']) ? $_GET['legajo'] : "";

if (!empty($mesFiltro)) {
    $sql .= " WHERE cuotas.mes = '$mesFiltro'";
}

if (!empty($estadoFiltro)) {
    if (!empty($mesFiltro)) {
        $sql .= " AND cuotas.estado = '$estadoFiltro'";
    } else {
        $sql .= " WHERE cuotas.estado = '$estadoFiltro'";
    }
}

if (!empty($legajoFiltro)) {
    $sql .= " AND alumno.legajo LIKE '%$legajoFiltro%'";
}elseif (!empty($estadoFiltro)) {
$sql .= " WHERE cuotas.estado = '$estadoFiltro'";
if (!empty($legajoFiltro)) {
    $sql .= " AND alumno.legajo LIKE '%$legajoFiltro%'";
}
}


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
    <title>Tabla de Cuotas</title>
</head>
<body>
    <h1>Tabla de Cuotas</h1>

    <form method="get">
        <label for="mes">Filtrar por Mes:</label>
        <input type="text" name="mes" id="mes" value="<?= $mesFiltro ?>">

        <label for="estado">Filtrar por Estado:</label>
        <select name="estado" id="estado">
            <option value="">Todos</option>
            <option value="pendiente" <?= ($estadoFiltro == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
            <option value="pagado" <?= ($estadoFiltro == 'pagado') ? 'selected' : '' ?>>Pagado</option>
        </select>

        <label for="legajo">Filtrar por Legajo:</label>
        <input type="text" name="legajo" id="legajo" value="<?= $legajoFiltro ?>">

        <input type="submit" value="Filtrar">
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Nombre del Alumno</th>
                <th>Legajo del Alumno</th>
                <th>Monto de la Cuota</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuotas as $cuota): ?>
                <tr>
                    <td><?= $cuota['mes'] ?></td>
                    <td><?= $cuota['nombre'] ?></td>
                    <td><?= $cuota['legajo'] ?></td>
                    <td><?= $cuota['monto'] ?></td>
                    <td><?= $cuota['estado'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
