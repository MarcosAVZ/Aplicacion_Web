<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Tabla de Cursos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

        body {
            background-color: #f5f5f5;
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
        <h1 style="text-align: center; color: #05429f">Tabla de Cursos</h1>
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
                <a href="cursosHorarios.php" class="list-group-item list-group-item-action active" aria-current="true">Cursos</a>
                <a href="totalPagos.php" class="list-group-item list-group-item-action">Cuotas</a>
            </div>
            <a href="..\index.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

    <?php
    // Conexión a la base de datos. Aquí debes agregar tus propios detalles de conexión.
    require '../conexion.php';
    $conn = conectar();

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consulta para obtener los cursos con sus aulas y horarios
    $sql = "SELECT DISTINCT c.curso, c.aula, h.dia, h.hora_inicio, h.hora_fin
    FROM cursos c
    INNER JOIN horario_curso hc ON c.id = hc.curso_id  
    INNER JOIN horario h ON hc.horario_id = h.id";

    $result = $conn->query($sql);

    // Verificar si se encontraron registros
    if ($result->num_rows > 0) {
        // Imprimir la tabla
        echo "<div>
            <table class='table'>
            <thead>        
                <tr>
                    <th scope='col'>Curso</th>
                    <th scope='col'>Aula</th>
                    <th scope='col'>Día</th>
                    <th scope='col'>Hora de inicio</th>
                    <th scope='col'>Hora de fin</th>
                </tr>
            </thead>";
        // Recorrer los resultados de la consulta
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["curso"] . "</td>
                    <td>" . $row["aula"] . "</td>
                    <td>" . $row["dia"] . "</td>
                    <td>" . $row["hora_inicio"] . "</td>
                    <td>" . $row["hora_fin"] . "</td>
                </tr>";
        }
        echo "</table>
            </div>
            <a class='no-print' type='button' onclick='imprimirTabla()'><img src='..\print.png' width='50px'></a>";
    } else {
        echo "No se encontraron cursos.";
    }

    // Cerrar conexión
    $conn->close();
    ?>

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