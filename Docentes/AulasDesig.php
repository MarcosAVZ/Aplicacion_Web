<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Aulas Designadas</title>
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
        <h1 style="text-align: center; color: #05429f">Aulas Designadas</h1>
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
                <a href="Docente.php" class="list-group-item list-group-item-action">Página Principal</a>
                <a href="listaAlumnos.php" class="list-group-item list-group-item-action">Lista de alumnos</a>
                <a href="AulasDesig.php" class="list-group-item list-group-item-action active" aria-current="true">Aulas designadas</a>
                <a href="calificar.php" class="list-group-item list-group-item-action">Calificar alumnos</a>
            </div>
            <a href="..\index.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

    <?php
    // Obtener el ID del docente actual (puedes reemplazar esto con tu lógica de autenticación)
    require_once '../conexion.php';

    $conn = conectar();
    // Verificar la conexión
    session_start();

    // Verificar si el usuario está autenticado como docente
    if (isset($_SESSION['user_id'])) {
        // Obtener el ID del docente de la variable de sesión
        $docente_Id = $_SESSION['user_id'];
    } else {
        // Manejar el caso en el que el docente no esté autenticado
        // Puedes redirigirlo a una página de inicio de sesión o mostrar un mensaje de error
        die("Docente no autenticado");
    }

    // Obtener los cursos vinculados al docente
    $sql = "SELECT DISTINCT cursos.id, cursos.curso, cursos.aula
            FROM cursos
            INNER JOIN docentes_cursos ON cursos.id = docentes_cursos.id_curso
            WHERE docentes_cursos.id_docente = $docente_Id";

    $result = $conn->query($sql);

    // Crear el selector de cursos
    echo "<form class='no-print' method='POST' action='AulasDesig.php'>";
    // echo "<label for='curso'>Selecciona un curso:</label>";
    echo "<br>
        <p class='h5'>Selecciona un curso: ";
    echo "<select name='curso' id='curso'>";
    while ($row = $result->fetch_assoc()) {
        $curso_id = $row['id'];
        $curso_nombre = $row['curso'];
        $curso_aula = $row['aula'];
        echo "<option value='$curso_id'>$curso_nombre</option>";
    }
    echo "</select>";
    echo "<input style='margin-left: 10px' type='submit' value='Mostrar horarios'>";
    echo "</p>
    </form>";

    // Mostrar la tabla con los horarios y aulas del curso seleccionado
    echo "<br>";

    if (isset($_POST['curso'])) {
        $curso_seleccionado = $_POST['curso'];

        echo "<h4>$curso_nombre</h4>";

        $sql = "SELECT DISTINCT horario.dia, horario.hora_inicio, horario.hora_fin, cursos.aula
                FROM horario
                INNER JOIN horario_curso ON horario.id = horario_curso.horario_id
                INNER JOIN cursos ON horario_curso.curso_id = cursos.id
                WHERE cursos.id = $curso_seleccionado";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>
                    <tr>
                        <th>Día</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                        <th>Aula</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                $dia = $row['dia'];
                $hora_inicio = $row['hora_inicio'];
                $hora_fin = $row['hora_fin'];
                $aula = $row['aula'];

                echo "<tr>
                        <td>$dia</td>
                        <td>$hora_inicio</td>
                        <td>$hora_fin</td>
                        <td>$aula</td>
                    </tr>";
            }

            echo "</table>";
            echo "<a class='no-print' type='button' onclick='imprimirTabla()'><img src='..\print.png' width='50px'></a>";
        } else {
            echo "No hay horarios disponibles para este curso.";
        }
    }

    // Cerrar la conexión a la base de datos
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