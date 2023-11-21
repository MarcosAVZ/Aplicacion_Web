<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../Css/styles.css">
  <title>Área de la Autoridad</title>
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
        <a href="../Personal/personal.php" class="list-group-item list-group-item-action">Seccion del Personal</a>
        <a href="../Docentes/Docente.php" class="list-group-item list-group-item-action">Seccion del Docente</a>
        <a href="../Padre/padre.php" class="list-group-item list-group-item-action">Seccion del Padre</a>
        <a href="../Alumno/Alumno.php" class="list-group-item list-group-item-action">Seccion del Alumno</a>
      </div>

      <div style="position: fixed; bottom: 20px">
        <button class="btn btn-secondary" id="modo-daltonico-btn" onclick="activarModoDaltonico()">Modo Daltónico</button>
        <a href="..\index2.php" class="btn btn-danger">Cerrar sesión</a>
      </div>
    </div>
  </div>
  <div class="card form-container mx-auto p-2 mt-3" style="width: 60vw">
    <p>
      Ingresó como <b>Administrador</b>, seleccione desde la barra lateral cualquier sección de la página para ver.<br>

      Al ingresar a una sección particular asumirá el rol correspondiente para ver lo mismo que un usuario de dicha categoría.
    </p>
  </div>
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