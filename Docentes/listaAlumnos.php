<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Selección de Curso</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header id="header" class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 id="titulo" style="text-align: center; color: #05429f">Lista de Alumnos</h1>
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
                    <a href="Docente.php" class="list-group-item list-group-item-action"><i class="bi bi-app pe-2" style="color: cornflowerblue;"></i>Página Principal</a>
                <?php
                }
                ?>
                <a href="listaAlumnos.php" class="list-group-item list-group-item-action active" aria-current="true"><i class="bi bi-people pe-2" style="color: cornflowerblue;"></i>Alumnos</a>
                <a href="AulasDesig.php" class="list-group-item list-group-item-action"><i class="bi bi-pentagon pe-2" style="color: cornflowerblue;"></i>Aula Designada</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-journal-check pe-2" style="color: cornflowerblue;"></i>Exámenes
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="calificar.php">Crear Instancia Examen</a></li>
                    <li><a class="dropdown-item" href="calificar2.php">Cargar Notas</a></li>
                </ul>
            </div>

            <div style="position: fixed; bottom: 20px">
                <button class="btn btn-secondary" id="modo-daltonico-btn" onclick="activarModoDaltonico()">Modo Daltónico</button>
                <a href="..\index2.php" class="btn btn-danger">Cerrar sesión</a>
            </div>

        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->
    <h1 class='no-print ms-3'>Selección de Curso</h1>

    <?php
    include '../Conexion.php';

    // Conectarse a la base de datos
    $conexion = conectar();

    // Obtener el id del docente
    if (isset($_SESSION['user_id'])) {
        // Obtener el ID del docente de la variable de sesión
        $id_docente = $_SESSION['user_id'];

        // Consulta para obtener los cursos del docente
        $cursos_docente = "SELECT c.id, c.nombre FROM cursodocente cd INNER JOIN curso c ON c.id = cd.idCurso WHERE cd.idDocente = $id_docente";
        $resultado_cursos_docente = mysqli_query($conexion, $cursos_docente);
    } else {
        // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
        header('Location: Docente.php');
        exit();
    }
    // Mostrar formulario para seleccionar el curso
    echo "<form action='' method='GET' class='no-print ms-3'>";
    echo "<div class='form-inline'>";
    echo "<select class='form-select' style='max-width: 200px' name='curso'>";
    while ($row = mysqli_fetch_array($resultado_cursos_docente)) {
        $id_curso = $row['id'];
        $nombre_curso = $row['nombre'];
        echo "<option value='$id_curso'>$nombre_curso</option>";
    }
    echo "</select>";
    echo "<input class='btn btn-primary' type='submit' value='Ver Alumnos'>";
    echo "</div>";
    echo "</form>";

    // Verificar si se ha seleccionado un curso
    if (isset($_GET['curso'])) {
        $id_curso_seleccionado = $_GET['curso'];

        // Consulta para obtener el nombre del curso seleccionado
        $consulta_curso = "SELECT nombre FROM curso WHERE id = $id_curso_seleccionado";
        $resultado_consulta_curso = mysqli_query($conexion, $consulta_curso);

        if (mysqli_num_rows($resultado_consulta_curso) > 0) {
            $row_curso = mysqli_fetch_assoc($resultado_consulta_curso);
            $nombre_curso_seleccionado = $row_curso['nombre'];

            // Consulta para verificar si el docente está relacionado con el curso seleccionado
            $consulta_relacion = "SELECT * FROM cursodocente WHERE idCurso = $id_curso_seleccionado AND idDocente = $id_docente";
            $resultado_consulta_relacion = mysqli_query($conexion, $consulta_relacion);

            if (mysqli_num_rows($resultado_consulta_relacion) > 0) {
                // Consulta para obtener los alumnos del curso seleccionado
                $alumnos_curso = "SELECT a.legajo, a.nombre, a.correo FROM alumnocurso ac INNER JOIN alumno a ON a.id = ac.idAlumno WHERE ac.idCurso = $id_curso_seleccionado";
                $resultado_alumnos_curso = mysqli_query($conexion, $alumnos_curso);

                // Mostrar el nombre del curso seleccionado
                echo "<h2 class='ms-3'>Curso seleccionado: $nombre_curso_seleccionado</h2>";

                // Mostrar los alumnos del curso seleccionado en una tabla
                echo "<table class='table table-striped table-bordered mx-auto p-2' style='width: 90vw'>";
                echo "<tr class='table-info'><th>Legajo</th><th>Nombre</th><th>Correo</th></tr>";
                while ($fila = mysqli_fetch_array($resultado_alumnos_curso)) {
                    echo "<tr>";
                    echo "<td>{$fila['legajo']}</td>";
                    echo "<td>{$fila['nombre']}</td>";
                    echo "<td>{$fila['correo']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>El docente no está relacionado con el curso seleccionado</p>";
            }
        } else {
            echo "<p>Curso no encontrado</p>";
        }
    }

    // Cerrar la conexión
    mysqli_close($conexion);
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

</html>