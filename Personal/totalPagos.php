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
    <title>Filtro de pagos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Pagos</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <img src="../Css/Logotipo200x200.png" class="rounded mx-auto d-block">
            </div>
            <div class="list-group">
                <a href="personal.php" class="list-group-item list-group-item-action">Página Principal</a>
                <a href="totalAlumnos.php" class="list-group-item list-group-item-action">Alumnos</a>
                <a href="totalPagos.php" class="list-group-item list-group-item-action active" aria-current="true">Cuotas</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cursos y Horarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cursosHorarios.php">Generar Horario</a></li>
                    <li><a class="dropdown-item" href="relacionarCursoHorario.php">Asignar Curso</a></li>
                </ul>
            </div>
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

    <section class="mt-2">
        <form class="no-print ms-3" method="post" action="totalPagos.php">
            <div class="form-inline">
                <input class="form-control max-width-input" type="text" placeholder="Legajo..." name="xlegajo" />
                <button class="btn btn-primary" name="buscar" type="submit">Buscar</button>
            </div>
        </form>
        <table class="table table-striped table-bordered mx-auto p-2" style="width: 90vw">
            <tr class="table-info">
                <th>Nombre</th>
                <th>Legajo</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Método de Pago</th>
            </tr>

            <?php
            if (isset($_POST['buscar'])) {
                $legajo = $_POST['xlegajo'];
                $where = "WHERE alumnos.legajo LIKE '" . $legajo . "%'";

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
    <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../Css/print.png' width='50px'></a>
    </div>
    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
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