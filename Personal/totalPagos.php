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

    <style>
        body {
            background-color: #f5f5f5;
        }

        .header {
            background-color: #3dfdb0;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            text-align: center;
            margin: 0;
        }

        .max-width-input {
            max-width: 300px;
            width: 100%;
        }

        #footer {
            position: fixed;
            right: 0;
            bottom: 0;
            margin: 0;
            padding: 0;
        }

        #footer img {
            width: 200px;
            opacity: 0.2;
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="..\hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Gestión de Pagos</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <img src="..\Logotipo200x200.png" class="rounded mx-auto d-block">
            </div>
            <div class="list-group">
                <a href="personal.php" class="list-group-item list-group-item-action">Página Principal</a>
                <a href="totalAlumnos.php" class="list-group-item list-group-item-action">Alumnos</a>
                <a href="cursosHorarios.php" class="list-group-item list-group-item-action">Cursos</a>
                <a href="totalPagos.php" class="list-group-item list-group-item-action active" aria-current="true">Cuotas</a>
            </div>
            <a href="..\index.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->
    <section>
        <form class="no-print" method="post" action="totalPagos.php">
            <div class="mb-3">
                <br>
                <h5 class="formlabel">Filtrar por legajo:</h5>
                <input class="form-control max-width-input" type="text" placeholder="Legajo..." name="xlegajo" />
                <br>
                <button class="btn btn-secondary" name="buscar" type="submit">Buscar</button>
            </div>
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
        <a class="no-print" type='button' onclick='imprimirTabla()'><img src='..\print.png' width='50px'></a>
    </section>

    <div id="footer">
        <img src="..\Logotipo200x200.png">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function imprimirTabla() {
            window.print();
        }
    </script>
</body>

</html>