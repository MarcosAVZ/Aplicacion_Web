<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Horarios</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header id="header" class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 id="titulo" style="text-align: center; color: #05429f">Horarios</h1>
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
                    <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action"><i class="bi bi-app pe-2" style="color: cornflowerblue;"></i>Página Principal</a>
                <?php
                } else {
                ?>
                    <a href="Alumno.php" class="list-group-item list-group-item-action"><i class="bi bi-app pe-2" style="color: cornflowerblue;"></i>Página Principal</a>
                <?php
                }
                ?>
                <a href="PassAlumno.php" class="list-group-item list-group-item-action"><i class="bi bi-key pe-2" style="color: cornflowerblue;"></i>Cambiar Contraseña</a>
                <a href="horarios.php" class="list-group-item list-group-item-action active"><i class="bi bi-calendar pe-2" style="color: cornflowerblue;"></i>Horarios</a>
                <a href="matricularCurso.php" class="list-group-item list-group-item-action"><i class="bi bi-pencil pe-2" style="color: cornflowerblue;"></i>Matricularse</a>
                <a href="boletin.php" class="list-group-item list-group-item-action"><i class="bi bi-card-list pe-2" style="color: cornflowerblue;"></i>Boletín</a>
            </div>

            <div style="position: fixed; bottom: 20px">
                <button class="btn btn-secondary" id="modo-daltonico-btn" onclick="activarModoDaltonico()">Modo Daltónico</button>
                <a href="..\index2.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->
    <?php

    // Obtener el ID del alumno (puedes obtenerlo de la sesión o de alguna otra manera)
    if (isset($_SESSION['user_id'])) {
        // Obtener el ID del docente de la variable de sesión
        $idAlumno = $_SESSION['user_id'];
    } else {
        // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
        header('Location: Alumno.php');
        exit();
    }
    // Conexión a la base de datos
    require '../conexion.php';
    $conn = conectar();

    $sqlCursos = "SELECT c.id, c.nombre
              FROM curso c
              INNER JOIN alumnocurso ac ON c.id = ac.idCurso
              WHERE ac.idAlumno = $idAlumno";

    $resultCursos = $conn->query($sqlCursos);

    ?>

    <!-- Formulario para seleccionar un curso -->
    <div class="ms-3 no-print">
        <form method="POST" action="">
            <h5 for="curso">Selecciona un curso:</h5>
            <div class="form-inline">
                <select class="form-select max-width-input" name="curso" id="curso">
                    <option value="mostrar_todo">Mostrar todo</option>
                    <?php while ($row = $resultCursos->fetch_assoc()) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button class="ms-1 btn btn-primary" type="submit">Mostrar horarios</button>
            </div>
        </form>
    </div>

    <div class="mx-auto p-2" style="width: 90vw">
        <?php
        // Verificar si se seleccionó un curso
        if (isset($_POST['curso'])) {
            $idCursoSeleccionado = $_POST['curso'];

            if ($idCursoSeleccionado == 'mostrar_todo') {
                // Consulta para obtener todos los horarios de todos los cursos vinculados al alumno
                $sqlHorarios = "SELECT h.id, h.dia, h.horaInicio, h.horaFin, h.Aula, c.nombre AS nombre_curso
                        FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        INNER JOIN curso c ON ch.idCurso = c.id
                        WHERE ch.idCurso IN (
                            SELECT ac.idCurso
                            FROM alumnocurso ac
                            WHERE ac.idAlumno = $idAlumno
                        )";

                $resultHorarios = $conn->query($sqlHorarios);

                // Mostrar los resultados en forma de tabla
                if ($resultHorarios->num_rows > 0) {
                    echo "<h3>Horarios de todos los cursos:</h3>";
                    echo "<table class=\"table table-bordered table-striped\">
                    <tr class='table-info'>
                        <th>Curso</th>
                        <th>Aula</th>
                        <th>Día</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                    </tr>";

                    while ($row = $resultHorarios->fetch_assoc()) {
                        $nombreCurso = $row["nombre_curso"];
                        $aula = $row["Aula"];
                        $dia = $row["dia"];
                        $horaInicio = $row["horaInicio"];
                        $horaFin = $row["horaFin"];
                        $horaInicioSinSegundos = substr($horaInicio, 0, 5);
                        $horaFinSinSegundos = substr($horaFin, 0, 5);

                        echo "<tr>
                        <td>$nombreCurso</td>
                        <td>$aula</td>
                        <td>$dia</td>
                        <td>$horaInicioSinSegundos</td>
                        <td>$horaFinSinSegundos</td>
                      </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No se encontraron horarios para los cursos vinculados al alumno.";
                }
            } else {
                // Consulta para obtener los horarios del curso seleccionado
                $sqlHorarios = "SELECT h.id, h.dia, h.horaInicio, h.horaFin, h.Aula, c.nombre AS nombre_curso
                        FROM horario h
                        INNER JOIN cursohorario ch ON h.id = ch.idHorario
                        INNER JOIN curso c ON ch.idCurso = c.id
                        WHERE ch.idCurso = $idCursoSeleccionado";

                $resultHorarios = $conn->query($sqlHorarios);

                // Mostrar los resultados en forma de tabla
                if ($resultHorarios->num_rows > 0) {
                    echo "<h2>Horarios del curso seleccionado:</h2>";
                    echo "<table class=\"table table-striped table-borderd\">
                    <tr class='table-info'>
                        <th>Curso</th>
                        <th>Aula</th>
                        <th>Día</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                    </tr>";

                    while ($row = $resultHorarios->fetch_assoc()) {
                        $nombreCurso = $row["nombre_curso"];
                        $aula = $row["Aula"];
                        $dia = $row["dia"];
                        $horaInicio = $row["horaInicio"];
                        $horaFin = $row["horaFin"];

                        echo "<tr>
                        <td>$nombreCurso</td>
                        <td>$aula</td>
                        <td>$dia</td>
                        <td>$horaInicio</td>
                        <td>$horaFin</td>
                      </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No se encontraron horarios para el curso seleccionado.";
                }
            }
        }

        ?>


        <?php
        $conn->close();
        ?>
    </div>
    <!-- Botón para imprimir tabla -->
    <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../Css/print.png' width='50px'></a>

    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Script para imprimir la tabla -->
    <script>
        function imprimirTabla() {
            window.print();
        }
    </script>

    <script>
        function activarModoDaltonico() {
            // Obtener el estado actual del modo daltónico
            var modoDaltonico = obtenerModoDaltonico();

            // Cambiar el estado del modo daltónico
            modoDaltonico = !modoDaltonico;

            // Guardar el estado del modo daltónico en una cookie con una duración de 30 días
            document.cookie = "modoDaltonico=" + modoDaltonico + "; expires=" + obtenerFechaExpiracion(30);

            // Aplicar los cambios del modo daltónico
            aplicarModoDaltonico(modoDaltonico);
        }

        function obtenerModoDaltonico() {
            // Obtener el valor de la cookie de modoDaltonico
            var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();

                // Verificar si la cookie es la de modoDaltonico
                if (cookie.indexOf("modoDaltonico=") === 0) {
                    // Obtener el valor de la cookie
                    var valor = cookie.substring("modoDaltonico=".length, cookie.length);

                    // Convertir el valor a booleano
                    return valor === "true";
                }
            }

            // Valor predeterminado si no se encuentra la cookie
            return false;
        }

        function aplicarModoDaltonico(modoDaltonico) {
            // Aquí puedes agregar el código para cambiar los estilos de tu página en modo daltónico
            // por ejemplo, cambiando los colores de fondo, texto, etc.

            if (modoDaltonico) {
                // Aplicar estilos para modo daltónico
                document.body.classList.add("modo-daltonico");
                document.getElementById("header").classList.add('modo-daltonico-header');
                // document.getElementById("titulo").classList.add('modo-daltonico-titulo');
                document.getElementById("titulo").style.color = "#f57600";

                const btnactive = document.querySelector('.active');
                btnactive.style.backgroundColor = 'yellow';
                btnactive.style.color = 'black';

                const btndanger = document.querySelector('.btn-danger');
                btndanger.style.backgroundColor = '#5ba300'
                btndanger.style.color = 'black';

                const btnprimary = document.querySelector('.btn-primary');
                btnprimary.style.backgroundColor = 'yellow';
                btnprimary.style.color = 'black';
            } else {
                // Quitar estilos de modo daltónico
                document.body.classList.remove("modo-daltonico");
                document.getElementById("header").classList.remove('modo-daltonico-header');
                document.getElementById("titulo").style.color = '#05429f';


                const btnactive = document.querySelector('.active');
                btnactive.style.backgroundColor = '#0d6efd';
                btnactive.style.color = 'white';

                const btndanger = document.querySelector('.btn-danger');
                btndanger.style.backgroundColor = '#dc3545'
                btndanger.style.color = 'white';

                const btnprimary = document.querySelector('.btn-primary');
                btnprimary.style.backgroundColor = '#0d6efd'
                btnprimary.style.color = 'white';
            }
        }

        function obtenerFechaExpiracion(dias) {
            var fecha = new Date();
            fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
            return fecha.toUTCString();
        }

        // Al cargar la página, aplicar el modo daltónico almacenado en la cookie
        window.onload = function() {
            var modoDaltonico = obtenerModoDaltonico();
            aplicarModoDaltonico(modoDaltonico);
        };
    </script>
</body>

</html>