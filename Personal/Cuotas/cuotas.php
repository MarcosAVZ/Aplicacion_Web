<!DOCTYPE html>
<html>
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
    if (!empty($mesFiltro) || !empty($estadoFiltro)) {
        $sql .= " AND alumno.legajo LIKE '%$legajoFiltro%'";
    } else {
        $sql .= " WHERE alumno.legajo LIKE '%$legajoFiltro%'";
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


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Css/styles.css">
    <title>Estado Pagos</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Estado Pagos</h1>
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
    <!-- Termina el bloque de código del sidebar -->
    <div class="mt-2 ms-2">
        <form method="get">
            <div class="form-inline">
            <label class="h5 ms-2" for="mes">Filtrar por Mes:</label>
                <select class="form-select ms-1" style="max-width: 150px;" name="mes" id="mes">
                    <option value="">Todos</option>
                    <option value="marzo" <?= ($mesFiltro == 'marzo') ? 'selected' : '' ?>>Marzo</option>
                    <option value="abril" <?= ($mesFiltro == 'abril') ? 'selected' : '' ?>>Abril</option>
                    <option value="mayo" <?= ($mesFiltro == 'mayo') ? 'selected' : '' ?>>Mayo</option>
                    <option value="junio" <?= ($mesFiltro == 'junio') ? 'selected' : '' ?>>Junio</option>
                    <option value="julio" <?= ($mesFiltro == 'julio') ? 'selected' : '' ?>>Julio</option>
                    <option value="agosto" <?= ($mesFiltro == 'agosto') ? 'selected' : '' ?>>Agosto</option>
                    <option value="septiembre" <?= ($mesFiltro == 'septiembre') ? 'selected' : '' ?>>Septiembre</option>
                    <option value="octubre" <?= ($mesFiltro == 'octubre') ? 'selected' : '' ?>>Octubre</option>
                    <option value="noviembre" <?= ($mesFiltro == 'noviembre') ? 'selected' : '' ?>>Noviembre</option>
                    <option value="diciembre" <?= ($mesFiltro == 'diciembre') ? 'selected' : '' ?>>Diciembre</option>
                </select>
                <label class="h5 ms-2" for="estado">Filtrar por Estado:</label>
                <select class="form-select ms-1" style="max-width: 150px;" name="estado" id="estado">
                    <option value="">Todos</option>
                    <option value="pendiente" <?= ($estadoFiltro == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                    <option value="pagado" <?= ($estadoFiltro == 'pagado') ? 'selected' : '' ?>>Pagado</option>
                </select>

                <label class="h5 ms-2" for="legajo">Filtrar por Legajo:</label>
                <input class="form-control ms-1" style="max-width: 150px;" type="text" name="legajo" id="legajo" value="<?= $legajoFiltro ?>">

                <input class="btn btn-primary ms-1 no-print" type="submit" value="Filtrar">
            </div>
        </form>
    </div>
    <div class="mt-2 mx-auto p-2" style="width: 90vw">
        <table class="table table-striped table-bordered">
            <tr class="table-info">
                <th>Mes</th>
                <th>Nombre del Alumno</th>
                <th>Legajo del Alumno</th>
                <th>Monto de la Cuota</th>
                <th>Estado</th>
            </tr>
            <tbody>
                <?php foreach ($cuotas as $cuota) : ?>
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