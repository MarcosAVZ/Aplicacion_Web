<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Horarios</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Horarios</h1>
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
                <a href="padre.php" class="list-group-item list-group-item-action">Página Principal</a>
                <a href="horarioHijo.php" class="list-group-item list-group-item-action active" aria-current="true">Horarios</a>
                <a href="boletinHijo.php" class="list-group-item list-group-item-action">Boletín</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cuotaPago/cuotasPagadas.php">Cuotas Pagadas</a></li>
                    <li><a class="dropdown-item" href="cuotaPago/pagar_cuota.php">Cuotas Pendientes</a></li>
                </ul>
            </div>
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

    <div class="mx-auto p-2" style="width: 90vw">
        <?php
        // Conexión a la base de datos
        require '../conexion.php';
        $conn = conectar();

        // Obtener el ID del padre (puedes obtenerlo mediante un formulario o cualquier otro método)
        $idPadre = 1; // ID del padre (debes reemplazarlo por el valor correspondiente)

        // Consulta para obtener los alumnos relacionados con el padre
        $sqlAlumnos = "SELECT id, nombre FROM alumno WHERE idPadre = $idPadre";

        $resultAlumnos = $conn->query($sqlAlumnos);

        // Verificar si se encontraron resultados
        if ($resultAlumnos->num_rows > 0) {
            // Mostrar la tabla de horarios para los alumnos encontrados
            echo "
        <table class=\"table table-striped table-bordered\">
            <tr class='table-info'>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Aula</th>
                <th>Día</th>
                <th>Hora de inicio</th>
                <th>Hora de fin</th>
            </tr>
            ";

            // Recorrer los resultados y mostrar los horarios para cada alumno
            while ($rowAlumno = $resultAlumnos->fetch_assoc()) {
                $idAlumno = $rowAlumno['id'];
                $nombreAlumno = $rowAlumno['nombre'];

                // Consulta para obtener los horarios del alumno actual
                $sqlHorarios = "SELECT h.id, h.dia, h.horaInicio, h.horaFin, h.Aula, c.nombre AS nombre_curso
                        FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        INNER JOIN curso c ON ch.idCurso = c.id
                        INNER JOIN alumnocurso ac ON c.id = ac.idCurso
                        WHERE ac.idAlumno = $idAlumno";

                $resultHorarios = $conn->query($sqlHorarios);

                // Mostrar los horarios del alumno actual en forma de filas de la tabla
                while ($rowHorario = $resultHorarios->fetch_assoc()) {
                    $nombreCurso = $rowHorario["nombre_curso"];
                    $aula = $rowHorario["Aula"];
                    $dia = $rowHorario["dia"];
                    $horaInicio = $rowHorario["horaInicio"];
                    $horaFin = $rowHorario["horaFin"];

                    $horaInicioSinSegundos = substr($horaInicio, 0, 5);
                    $horaFinSinSegundos = substr($horaFin, 0, 5);

                    echo "
                <tr>
                    <td>$nombreAlumno</td>
                    <td>$nombreCurso</td>
                    <td>$aula</td>
                    <td>$dia</td>
                    <td>$horaInicioSinSegundos</td>
                    <td>$horaFinSinSegundos</td>
                </tr>
            ";
                }
            }

            echo "</table>";
        } else {
            echo "No se encontraron alumnos vinculados al padre.";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </div>

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