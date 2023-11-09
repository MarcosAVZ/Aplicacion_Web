<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Css/styles.css">
    <title>Tabla de pagos</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Lista de Pagos</h1>
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
            <?php  
                session_start();
                if (isset($_SESSION['autoridad']) && $_SESSION['autoridad'] == 1) {
                ?>
                <a href="../../Autoridad/autoridad.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php  
                }else{
                ?>
                <a href="../personal.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php 
                }
            ?>
                <a href="../totalAlumnos.php" class="list-group-item list-group-item-action">Alumnos</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="Pagos.php">Lista Pagos</a></li>
                    <li><a class="dropdown-item" href="cuotas.php">Estado Pagos</a></li>
                    <li><a class="dropdown-item" href="../montoCuota.php">Actualizar precios</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos y Horarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../cursosHorarios.php">Generar Horario</a></li>
                    <li><a class="dropdown-item" href="../relacionarCursoHorario.php">Asignar Curso</a></li>
                </ul>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Matriculación
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../MatricularAlumno.php">Matricular Alumno</a></li>
                    <li><a class="dropdown-item" href="../MatricularPadre.php">Matricular Padre</a></li>
                </ul>

            </div>
        </div>
        <a href="..\..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
    </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

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
    <div class="mt-2 row g-3 align-items-center">
        <form class="ms-3" method="get">
            <div class="form-inline">
                <label class="h5" for="fecha_inicio">Fecha de Inicio:</label>
                <input class="ms-2 form-control" style="max-width: 150px;" type="date" name="fecha_inicio" id="fecha_inicio" value="<?= $fechaInicio ?>">

                <label class="h5" for="fecha_fin">Fecha de Fin:</label>
                <input class="ms-2 form-control" style="max-width: 150px;" type="date" name="fecha_fin" id="fecha_fin" value="<?= $fechaFin ?>">

                <label class="h5" for="metodo_pago">Método de Pago:</label>
                <select class="form-select ms-2" style="max-width: 150px;" name="metodo_pago" id="metodo_pago">
                    <option value="">Todos</option>
                    <option value="Efectivo" <?= ($metodoPago == 'Efectivo') ? 'selected' : '' ?>>Efectivo</option>
                    <option value="Crédito" <?= ($metodoPago == 'Crédito') ? 'selected' : '' ?>>Crédito</option>
                    <option value="Débito" <?= ($metodoPago == 'Débito') ? 'selected' : '' ?>>Débito</option>
                </select>

                <input class="btn btn-primary ms-2 no-print" type="submit" value="Filtrar">
            </div>
        </form>
    </div>
    <div class="mt-2 mx-auto p-2" style="width: 90vw">
        <table class="table table-striped table-bordered">
            <tr class="table-info">
                <th>Correo del Padre</th>
                <th>Nombre del Alumno</th>
                <th>Legajo del Alumno</th>
                <th>Monto del Pago</th>
                <th>Método de Pago</th>
                <th>Fecha</th>
                <th>Mes</th>
                <th>Comprobante</th>
            </tr>
            <tbody>
                <?php foreach ($pagos as $pago) : ?>
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

        <!-- Botón para imprimir tabla -->
        <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../../Css/print.png' width='50px'></a>
    </div>
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