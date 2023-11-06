<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../Css/styles.css">
  <title>Área del Padre</title>
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
        <a href="padre.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
        <a href="horarioHijo.php" class="list-group-item list-group-item-action">Horarios</a>
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

  <?php
  include '../Conexion.php';

    $padreId = 1;

    // Obtener el nombre del docente de la base de datos
    $db = conectar(); // Asegúrate de tener la conexión a la base de datos establecida
    $query = "SELECT nombre FROM padre WHERE id = $padreId";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $nombrePadre = $row['nombre'];

    // Imprimir el mensaje de bienvenida
    echo "<h2>Hola $nombrePadre, bienvenido al Área del Padre.</h2>";

$conn = conectar(); 

// Verificar la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la fecha actual
$fechaActual = date("Y-m-d");

// Calcular el mes y año actual en español
setlocale(LC_TIME, 'es_ES'); // Establecer localización en español
$mesActual = ucfirst(strftime("%B")); // Nombre completo del mes en español (por ejemplo, "Enero")
$anoActual = date("Y");

$sqlMontoCuota = "SELECT monto FROM montos_cuota WHERE id = 1";
$resultMontoCuota = $conn->query($sqlMontoCuota);

if ($resultMontoCuota->num_rows > 0) {
  $rowMontoCuota = $resultMontoCuota->fetch_assoc();
  $montoCuota = $rowMontoCuota["monto"];
} else {
  $montoCuota = 0.00; // Valor predeterminado si no se encuentra un monto
}

// Consultar todos los padres
$sqlPadres = "SELECT id FROM padre";
$resultPadres = $conn->query($sqlPadres);

if ($resultPadres->num_rows > 0) {
  while ($rowPadre = $resultPadres->fetch_assoc()) {
      $idPadre = $rowPadre["id"];
      
      // Verificar si ya existe una cuota para este padre en el mes actual
      $sqlExistente = "SELECT id FROM cuotas WHERE id_padre = $idPadre AND mes = '$mesActual' AND año = $anoActual";
      $resultExistente = $conn->query($sqlExistente);
      
      if ($resultExistente->num_rows == 0) {
          // Si no existe una cuota para este padre en el mes actual, insertar una nueva cuota
          $estadoCuota = "pendiente"; // Puedes cambiar el estado inicial
          
          // Consultar los alumnos asociados a este padre
          $sqlAlumnos = "SELECT idAlumno FROM cuotas WHERE id_padre = $idPadre";
          $resultAlumnos = $conn->query($sqlAlumnos);
          
          if ($resultAlumnos->num_rows > 0) {
              while ($rowAlumno = $resultAlumnos->fetch_assoc()) {
                  $idAlumno = $rowAlumno["idAlumno"];
                  
                  // Verificar si ya existe una cuota para este alumno en el mes actual
                  $sqlCuotaExistente = "SELECT id FROM cuotas WHERE id_padre = $idPadre AND idAlumno = $idAlumno AND mes = '$mesActual' AND año = $anoActual";
                  $resultCuotaExistente = $conn->query($sqlCuotaExistente);
                  
                  if ($resultCuotaExistente->num_rows == 0) {
                      $sqlInsert = "INSERT INTO cuotas (id_padre, idAlumno, mes, año, monto, estado) VALUES ($idPadre, $idAlumno, '$mesActual', $anoActual, $montoCuota, '$estadoCuota')";
                      
                      if ($conn->query($sqlInsert) === TRUE) {
                        
                      } else {
                          echo "Error al insertar la cuota: " . $conn->error;
                      }
                  }
              }
          }
      }
  }
} else {
  echo "No se encontraron padres en la base de datos.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
  <div id="footer">
    <img src="../Css/Logotipo200x200.png">
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>

