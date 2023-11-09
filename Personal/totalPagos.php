<?php

// Establecer la conexión a la base de datos
require '../conexion.php';
$conexion = conectar();

/////////////////////////////////////Listado de pagos por parte de los alumnos////////////////////////////////////////////
if ($conexion->connect_errno) {
    die("Fallo la conexión: (" . $conexion->connect_errno . ")" . $conexion->connect_error);
}
?>

<html lang="es">
<head>
    <a href="personal.php">Volver</a>
    <title>Filtro de pagos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
</head>
<body>
<header>
    <div class="alert alert-info">
        <h2>Pago de cuotas</h2>
    </div>
</header>
<section>
    <form method="post" action="totalPagos.php">
        <input type="text" placeholder="Legajo..." name="xlegajo" />
        <button name="buscar" type="submit">Buscar</button>
    </form>
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Legajo</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Método de Pago</th>
        </tr>

        <?php
        if(isset($_POST['buscar'])){
            $legajo = $_POST['xlegajo'];
            $where = "WHERE alumnos.legajo LIKE '".$legajo."%'";

            // Consulta a la base de datos
            $consulta = "SELECT DISTINCT alumnos.nombre, alumnos.legajo, pagos.monto, pagos.fecha, pagos.metodo_pago 
                        FROM alumnos
                        LEFT JOIN pagos ON alumnos.id = pagos.alumno_id
                        $where";
            $resultado = $conexion->query($consulta);

            if (mysqli_num_rows($resultado) == 0) {
                $mensaje = "<h1>No hay registros que coincidan con su criterio de búsqueda.</h1>";
            } else {
                while ($registroAlumnos = $resultado->fetch_array(MYSQLI_BOTH)) {
                    echo '<tr>
                            <td>' . $registroAlumnos['nombre'] . '</td>
                            <td>' . $registroAlumnos['legajo'] . '</td>
                            <td>' . $registroAlumnos['monto'] . '</td>
                            <td>' . $registroAlumnos['fecha'] . '</td>
                            <td>' . $registroAlumnos['metodo_pago'] . '</td>
                        </tr>';
                }
            }
        }
        ?>

    </table>
</section>
</body>
</html>