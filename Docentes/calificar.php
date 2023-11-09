<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Área del Docente</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Crear Instancia de Examen</h1>
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
                <a href="AulasDesig.php" class="list-group-item list-group-item-action">Aula Designada</a>
                <a class="dropdown-toggle list-group-item list-group-item-action active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

// Verificar si el docente ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    // Obtener el ID del docente de la variable de sesión
    $docenteId = $_SESSION['user_id'];


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
    } else {
    // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
    header('Location: Docente.php');
    exit();
     }
    // Verificar si se encontraron materias
    if ($result->num_rows > 0) {
        // Materias encontradas, generar opciones para el elemento select
        $options = "";
        while ($row = $result->fetch_assoc()) {
            $idMateria = $row['id'];
            $nombreMateria = $row['nombre'];
            $options .= "<option value='$idMateria'>$nombreMateria</option>";
        }
    } else {
        // No se encontraron materias vinculadas al docente
        $options = "<option value='' disabled selected>No hay materias disponibles</option>";
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
            echo "El examen se ha guardado correctamente.";
        } else {
            echo "Error al guardar el examen: " . $conn->error;
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    }
    ?>

    <!-- Formulario HTML -->
    <div class="card form-container mx-auto p-2 mt-3" style="width: 500px">
        <form method="POST" action="">
            <h5 lcass="form-label" for="nombre_examen">Nombre del examen:</h5>
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

</body>

</html>