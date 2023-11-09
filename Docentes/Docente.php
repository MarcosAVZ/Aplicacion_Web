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
    <h1 style="text-align: center; color: #05429f">Sistema de Gestión de Educar para Transformar</h1>
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
  include '../Conexion.php';

  // Verificar si el usuario está autenticado como docente
  if (isset($_SESSION['user_id'])) {
    // Obtener el ID del docente de la variable de sesión
    $docenteId = $_SESSION['user_id'];

    // Obtener el nombre del docente de la base de datos
    $db = conectar(); // Asegúrate de tener la conexión a la base de datos establecida
    $query = "SELECT nombre FROM docente WHERE id = $docenteId";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $nombreDocente = $row['nombre'];

    // Imprimir el mensaje de bienvenida
    echo "<h2>Hola $nombreDocente, bienvenido al Área del Docente.</h2>";
  } else {
    // Si el usuario no está autenticado, redirigir al archivo de inicio de sesión
    header('Location: index.php');
    exit();
  }
  ?>
  <div class="card form-container mx-auto p-2 mt-3" style="width: 60vw">
    <p>
    <h3>CICLO 2023</h3>
    La ventanilla de pagos funciona en la facultad de lunes a viernes de 17 a 19 hs, pero en lo posible solicitamos paguen por transferencia.<br>
    Por Favor para abonar tener en cuenta la siguiente información:<br>
    Transferir el importe a los datos de la cuenta que figuran abajo y enviar el comprobante de depósito o transferencia por correo electrónico a tesoreria@educar.transformar.ar, con copia al correo de la carrera<br>
    CUIT: 21607420866<br>
    RAZÓN SOCIAL: CENTRO EDUCATIVO EDUCAR PARA TRANSFORMAR<br>
    TIPO CUENTA 03 - CC $ NÚMERO CUENTA 2910914352168<br>
    CBU 1747155411100067955364 ALIAS EPT.RESIS<br>
    Si no recuerdan su nro de legajo y/o contraseña, deben dirigirse a Alumnado.<br>
    </p>
  </div>
  <div class="card form-container mx-auto p-2 mt-3" style="width: 60vw">
    <p>

      El <b>Centro Educativo - Educar Para Transformar - Resistencia</b> pone a disposición de la comunidad educativa este"Entorno Virtual".<br>

      El objetivo es servir de base para el desarrollo de actividades on - line.<br>
      Este entorno puede ser utilizado para simplemente colocar material e información a disposición de los alumnos o manejar completamente el curso a través del Entorno Virtual.<br>
      Desarrollado por Almenar Ignacio y Avanzatti Marcos para la carrera de Tecnicatura Universitaria en Programación de la UTN FRRe.
    </p>
  </div>

  <div id="footer">
    <img src="../Css/Logotipo200x200.png">
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>