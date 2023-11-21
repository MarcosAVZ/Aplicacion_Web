<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Área del Docente</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header id="header" class="header">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 id="titulo" style="text-align: center; color: #05429f">Crear Instancia de Examen</h1>
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
                <a href="listaAlumnos.php" class="list-group-item list-group-item-action"><i class="bi bi-people pe-2" style="color: cornflowerblue;"></i>Alumnos</a>
                <a href="AulasDesig.php" class="list-group-item list-group-item-action"><i class="bi bi-pentagon pe-2" style="color: cornflowerblue;"></i>Aula Designada</a>
                <a class="dropdown-toggle list-group-item list-group-item-action active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <?php


    // Verificar si el docente ha iniciado sesión
    if (isset($_SESSION['user_id'])) {
        // Obtener el ID del docente de la variable de sesión
        $docenteId = $_SESSION['user_id'];
    } else {
        // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
        header('Location: Docente.php');
        exit();
    }
    // Obtener el ID del docente de la sesión

    // Obtener las materias vinculadas al docente desde la base de datos
    include '../Conexion.php';

    // Conectarse a la base de datos
    $conn = conectar();

    // Verificar si hay errores en la conexión
    if ($conn->connect_error) {
        die("Error en la conexión a la base de datos: " . $conn->connect_error);
    }

    // Obtener las materias vinculadas al docente
    $sql = "SELECT c.id, c.nombre AS nombre
        FROM curso AS c
        JOIN cursodocente AS cd ON c.id = cd.idCurso
        JOIN docente AS d ON cd.idDocente = d.id
        WHERE d.id = '$docenteId'";
    $result = $conn->query($sql);

    // Verificar si se encontraron materias
    if ($result->num_rows > 0) {
        // Materias encontradas, generar opciones para el elemento select
        $options = "";
        while ($row = $result->fetch_assoc()) {
            $idMateria = $row['id'];
            $nombreMateria = $row['nombre'];
            $options .= "<option value='$idMateria'>$nombreMateria</option>";
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Procesar el formulario cuando se envíe
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombreExamen = $_POST["nombre_examen"];
        $idMateria = $_POST["id_materia"];

        // Conectarse a la base de datos nuevamente
        $conn = conectar();

        // Verificar si hay errores en la conexión
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        // Insertar el nuevo examen en la tabla "examen"
        $sql = "INSERT INTO examen (nombre, idCurso, idDocente) VALUES ('$nombreExamen', '$idMateria', '$docenteId')";

        if ($conn->query($sql) === true) {
            echo "<div class=\"alert-success mx-auto card-width\">
                    <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    El examen se ha guardado correctamente.
                  </div>";
        } else {
            echo "<div class=\"alert mx-auto card-width\">
                    <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    Error al actualizar lista de exámenes: " . $conn->error . "
                  </div>";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    }
    ?>

    <!-- Formulario HTML -->
    <div class="card form-container mx-auto p-2 mt-3 card-width">
        <form method="POST" action="">
            <h5 class="form-label" for="nombre_examen">Nombre del examen:</h5>
            <input class="form-control" type="text" name="nombre_examen" required><br>

            <h5 class="form-label" for="id_materia">Materia:</h5>
            <select class="form-select" name="id_materia" required>
                <?php echo $options; ?>
            </select><br>

            <input class="btn btn-primary" type="submit" value="Guardar">
        </form>
    </div>
    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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