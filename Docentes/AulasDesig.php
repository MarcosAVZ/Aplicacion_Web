<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Aulas Designadas</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Designación de Aulas</h1>
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
            <?php  
                session_start();
                if (isset($_SESSION['autoridad']) && $_SESSION['autoridad'] == 1) {
                ?>
                <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php  
                }else{
                ?>
                <a href="Docente.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php 
                }
            ?>
                <a href="listaAlumnos.php" class="list-group-item list-group-item-action">Alumnos</a>
                <a href="AulasDesig.php" class="list-group-item list-group-item-action active" aria-current="true">Aula Designada</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Exámenes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="calificar.php">Crear Instancia Examen</a></li>
                    <li><a class="dropdown-item" href="calificar2.php">Cargar Notas</a></li>
                </ul>
            </div>
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->
    <?php
    // Conexión a la base de datos
    require '../conexion.php';
    $conn = conectar();
    

    // Verificar si el docente ha iniciado sesión
    if (isset($_SESSION['user_id'])) {
        // Obtener el ID del docente de la variable de sesión
        $docenteId = $_SESSION['user_id'];

    // Consulta para obtener los cursos vinculados al docente
    $sql = "SELECT c.id, c.nombre FROM curso c
        INNER JOIN cursodocente cd ON c.id = cd.idCurso
        WHERE cd.idDocente = $docenteId";

    $result = $conn->query($sql);
    } else {
    // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
    header('Location: Docente.php');
    exit();
     }
    if ($result->num_rows > 0) {
        // Mostrar los cursos y sus horarios en forma de tabla
        echo "<table class='table table-striped table-bordered mx-auto p-2 mt-3' style='width: 90vw'>
            <tr class='table-info'>
                <th>Curso</th>
                <th>Día</th>
                <th>Horario de inicio</th>
                <th>Horario de fin</th>
                <th>Aula</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            $cursoId = $row["id"];
            $cursoNombre = $row["nombre"];

            // Consulta para obtener los horarios vinculados al curso
            $horariosSql = "SELECT h.dia, h.horaInicio, h.horaFin, h.Aula FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        WHERE ch.idCurso = $cursoId";

            $horariosResult = $conn->query($horariosSql);

            while ($horarioRow = $horariosResult->fetch_assoc()) {
                $horarioDia = $horarioRow["dia"];
                $horarioInicio = $horarioRow["horaInicio"];
                $horarioFin = $horarioRow["horaFin"];
                $Aulas = $horarioRow["Aula"];
                $horaInicioSinSegundos = substr($horarioInicio, 0, 5);
$horaFinSinSegundos = substr($horarioFin, 0, 5);

                echo "<tr>
                    <td>$cursoNombre</td>
                    <td>$horarioDia</td>
                    <td>$horaInicioSinSegundos</td>
                    <td>$horaFinSinSegundos</td>
                    <td>$Aulas</td>
                </tr>";
            }
        }

        echo "</table>";
    } else {
        echo "No se encontraron cursos vinculados al docente.";
    }

    $conn->close();
    ?>
    <!-- Botón para imprimir tabla -->
    <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../Css/print.png' width='50px'></a>

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