<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../Css/styles.css">
  <title>Área del Padre</title>
</head>

<body>
  <!-- Código para la barra lateral -->
  <header id="header" class="header">
    <!-- Cambiar título para que corresponda a la página -->
    <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <img src="../Css/hamburguesa.png" width="50px">
    </a>
    <h1 id="titulo" style="text-align: center; color: #05429f">Sistema de Gestión de Educar para Transformar</h1>
  </header>
  <?php
  session_start();
  ?>
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
          <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action active"><i class="bi bi-app pe-2" style="color: cornflowerblue;"></i>Página Principal</a>
        <?php
        } else {
        ?>
          <a href="padre.php" class="list-group-item list-group-item-action active"><i class="bi bi-app pe-2" style="color: cornflowerblue;"></i>Página Principal</a>
        <?php
        }
        ?>
        <a href="horarioHijo.php" class="list-group-item list-group-item-action"><i class="bi bi-calendar pe-2" style="color: cornflowerblue;"></i>Horarios</a>
        <a href="boletinHijo.php" class="list-group-item list-group-item-action"><i class="bi bi-card-list pe-2" style="color: cornflowerblue;"></i>Boletín</a>
        <a href="PassPadre.php" class="list-group-item list-group-item-action"><i class="bi bi-key pe-2" style="color: cornflowerblue;"></i>Cambiar Contraseña</a>
        <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-cash-coin  pe-2" style="color: cornflowerblue;"></i>Pagos
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="cuotaPago/cuotasPagadas.php">Cuotas Pagadas</a></li>
          <li><a class="dropdown-item" href="cuotaPago/pagar_cuota.php">Cuotas Pendientes</a></li>
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

  include '../Conexion.php';

  if (isset($_SESSION['user_id'])) {
    $padreId = $_SESSION['user_id'];

    // Obtener el nombre del docente de la base de datos
    $db = conectar(); // Asegúrate de tener la conexión a la base de datos establecida
    $query = "SELECT nombre FROM padre WHERE id = $padreId";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $nombrePadre = $row['nombre'];

    // Imprimir el mensaje de bienvenida
    echo "<h2>Hola $nombrePadre, bienvenido al Área del Padre.</h2>";
  } else {
    // Si no se ha iniciado sesión, puedes redirigir al usuario a la página de inicio de sesión
    header('Location: ../index2.php');
    exit();
  }
  $conn = conectar();

  // Verificar la conexión
  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }

  // Obtener la fecha actual
  $fechaActual = date("Y-m-d");

  // Mapeo de nombres de meses en inglés a español
  $mesesEnEspanol = [
    "January" => "Enero",
    "February" => "Febrero",
    "March" => "Marzo",
    "April" => "Abril",
    "May" => "Mayo",
    "June" => "Junio",
    "July" => "Julio",
    "August" => "Agosto",
    "September" => "Septiembre",
    "October" => "Octubre",
    "November" => "Noviembre",
    "December" => "Diciembre"
  ];

  // Establecer la localización en español
  setlocale(LC_TIME, 'es_ES');

  // Obtener el nombre completo del mes en inglés
  $mesEnIngles = date("F");
  $anoActual = date("Y");
  // Obtener el nombre del mes en español a partir del mapeo
  $mesActual = $mesesEnEspanol[$mesEnIngles];



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
        $sqlAlumnos = "SELECT id FROM alumno WHERE idPadre = $idPadre";
        $resultAlumnos = $conn->query($sqlAlumnos);

        if ($resultAlumnos->num_rows > 0) {
          while ($rowAlumno = $resultAlumnos->fetch_assoc()) {
            $idAlumno = $rowAlumno["id"];

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