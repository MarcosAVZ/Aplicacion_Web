<?php
session_start();
// Asegúrate de tener la conexión a la base de datos establecida
include '../Conexion.php';
$conn = conectar();

// Obtener el ID del alumno (esto debe ajustarse según tu lógica de la aplicación)
if (isset($_SESSION['user_id'])) {
    // Obtener el ID del docente de la variable de sesión
    $alumno_id = $_SESSION['user_id'];
} else {
    // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
    header('Location: ../index2.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $curso_id = $_POST["curso"];

    // Insertar la relación alumno-curso en la base de datos
    $query = "INSERT INTO alumnocurso (idAlumno, idCurso) VALUES ('$alumno_id', '$curso_id')";
    $conn->query($query);

    // Redirigir a una página de éxito o a la página principal
    header("Location: matricularCurso.php?success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Matricular Alumno en Cursos</title>
</head>

<body>
    <!-- Barra lateral -->
    <header class="header no-print">
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Ingresar a Curso</h1>
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
                if (isset($_SESSION['autoridad']) && $_SESSION['autoridad'] == 1) {
                ?>
                <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action" aria-current="true">Página Principal</a>
                <?php  
                }else{
                ?>
                <a href="Alumno.php" class="list-group-item list-group-item-action" aria-current="true">Página Principal</a>
                <?php 
                }
            ?>
        <a href="PassAlumno.php" class="list-group-item list-group-item-action">Cambiar Contraseña</a>
        <a href="horarios.php" class="list-group-item list-group-item-action">Horarios</a>
        <a href="matricularCurso.php" class="list-group-item list-group-item-action active">Matricularse</a>
        <a href="boletin.php" class="list-group-item list-group-item-action">Boletín</a>
            </div>
            <a href="../index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Fin de la barra lateral -->

    <!-- Contenido principal -->
    <div class="card form-container mx-auto p-2 mt-3 card-width">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>">

            <h2>Ingresar a Curso</h2>

            <div class="form-row">
                <label class="h5" for="curso">Seleccionar Curso:</label>
                <select class="form-select" name="curso" id="curso" required>
                    <?php
                    // Obtener cursos no matriculados por el alumno
                    // (Necesitarás adaptar la consulta según tu esquema de base de datos)
                    $query = "SELECT id, nombre FROM curso WHERE id NOT IN (SELECT idCurso FROM alumnocurso WHERE idAlumno = $alumno_id)";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <input class="btn btn-primary mt-2" type="submit" value="Matricular en Curso">
        </form>
    </div>
    <!-- Fin del contenido principal -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

