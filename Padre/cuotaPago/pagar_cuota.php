<!DOCTYPE html>
<html>

<head>
    <title>Pago de Cuotas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Css/styles.css">
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Cuotas Pendientes</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <img src="../../Css/Logotipo200x200.png" class="rounded mx-auto d-block">
            </div>
            <div class="list-group">
                <a href="../padre.php" class="list-group-item list-group-item-action">Página Principal</a>
                <a href="../horarioHijo.php" class="list-group-item list-group-item-action">Horarios</a>
                <a href="../boletinHijo.php" class="list-group-item list-group-item-action">Boletín</a>
                <a class="dropdown-toggle list-group-item list-group-item-action active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cuotasPagadas.php">Cuotas Pagadas</a></li>
                    <li><a class="dropdown-item" href="pagar_cuota.php">Cuotas Pendientes</a></li>
                </ul>
            </div>
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

    <div class="ms-3 mt-3 no-print  ">
        <a class="btn btn-primary" href="procesar_pago.php">Realizar Pago</a>
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
            echo "<small class='text-body-secondary'>Estado de las cuotas actualizado correctamente.</small>";
        } else {
            echo "<small class='text-body-secondary'>Error al actualizar el estado de las cuotas: </small>" . mysqli_error($conexion);
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

    </div>

    <div class="mt-2 mx-auto p-2" style="width: 90vw">
        <table class="table table-striped table-bordered">
            <tr class="table-info">
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

    <!-- Botón para imprimir tabla -->
    </div>
    <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../../Css/print.png' width='50px'></a>
    <div id="footer">
        <img src="../../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Script para imprimir la tabla -->
<script>
    function imprimirTabla() {
        window.print();
    }
</script>

</html>