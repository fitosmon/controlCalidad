<?php 
    include "seguridad.php";
    
    if (isset($_SESSION["toastmesaje"])) {
      // Mostrar el mensaje del toast
      echo $_SESSION["toastmesaje"];
      // Eliminar la variable de sesión del mensaje del toast
      unset($_SESSION["toastmesaje"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel</title>
    <link rel="icon" href="img/Icon v2.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril+Fatface|Poppins">
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Semi+Condensed:wght@600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/principal.css">
    <link rel="stylesheet" href="css/notificaciones.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="js/js1.js"></script>
    <script src="js/notificacion.js"></script>

    <script>
        Notification.requestPermission().then(function(permission) {
            if (permission !== "granted") {
                // Si el permiso no se ha otorgado, abrir el modal de Bootstrap
                $('#modalNoti').modal('show');
            }
        });
    </script>

    <!-- Inicializando el calendario -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });
    </script>
</head>
<body>
<!--Se crea un separador para el menu y las notificaciones-->
<div class="shadow p-3 bg-white">
  <div class="container-fluid pb-3">
    <div class="offcanvas offcanvas-start" id="demo">
        <div class="offcanvas-header">
            <img class ="logoig" src="img/Icon v2.png">
            <h2 class="offcanvas-title">NOTIZEN</h2>
            <button type="button" class="btn-close m-2" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <!--Filtro-->
            <ul id="menu"> <!-- Esto sirve para generar un menú desplegable-->
                <li class="nivel1"><i class='bx bx-home iconom'></i><a href="principal.php">Inicio</a></li>
                <?php require "filtromenu.php"; ?>
                <!-- elementos de menú, un elemento de lista <li> y un enlace <a> -->
                <li class="nivel1"><i class='bx bx-collection iconom'></i><a href="semestredetalles.php">Semestres</a></li>
                <li class="nivel1"><i class='bx bx-task iconom'></i><a href="tareadetalle.php">Tareas</a></li>
		        <li class="nivel1"><i class='bx bx-share-alt iconom'></i><a href="compartida.php">Compartidas</a></li>
                <li class="nivel1"><i class='bx bx-note iconom'></i><a href="notadetalle.php">Notas</a></li>
                <li class="nivel1"><i class='bx bx-spa iconom'></i><a href="estudio.php">Sesión de Estudio</a></li>
		        <li class="nivel1"><i class='bx bx-group iconom'></i><a href="amigos.php">Amigos</a></li>
                <li class="nivel1 mb-5"><i class='bx bx-cog iconom'></i><a href="configuracion.php" >Configuración</a></li>
            </ul>
            <?php require "barrauser.php"; ?>
        </div>
    </div>
    <!--Linea que separa al menu y la notificacion-->
    <div class="container-fluid mt-3">
        <div class="row align-items-center">
            <!--Botón para menú horizontal-->
            <div class="col-11">
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo" id="btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <!--Notificaciones-->
            <div class="col-1">
                <div class="ml-auto">
                    <div class="dropdown">
                        <?php require "amigos/notificaciones.php";?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Fin linea-->
 </div>
</div>

    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-9 mb-3">
                <div id='calendar'></div>
                <?php
                    // Incluir el archivo obtener_tareas.php
                    require "obtenerNotificacion.php";
                ?>
            </div>
            <div class="col-lg-3">
                <div class="container card">
                    <div class="row card-header">
                    <div class="col-8">Notas</div>
                    <div class=" col-4 text-end" id="ico"><a href="#creanota" data-bs-toggle="modal" class="btn material-symbols-outlined" id="btn">add</a></div>
                    
                    <?php require "notas.php"; load($conexion, 0);?>

                </div>
            </div>
        </div>
    </div>

<!-- Crear notas rapidas -->
    <div class="modal fade" id="creanota">
        <div class="modal-dialog row">
            <div class="modal-content col-ls-12">
                <form action="notas.php" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <div class="col-6"><img src="img/Icon v2.png" alt="Logo" class="logoig"></div>
                        <div class="col-6 text-end"><input type="submit" value="Crear Nota" class="btn" id="btn"></div>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body row">
                            <div class="col-12">
                                <label for="nombreNota" class="fw-bold col-8 form-label">Nombre Nota:</label>
                                <input type="text" name="nombreNota" class="col-4 form-control" maxlength="50" pattern="^(?=.*[a-zA-Z0-9])[\sa-zA-ZáéíóúÁÉÍÓÚñÑ0-9!@#$%^&*_+-={}?]{1,50}$"
                                title="Letras mayúsculas, minúsculas, números, carácteres especiales y espacios permitidos" required>
                            </div>
                            <div class="pt-2"></div>
                            <div class="col-12">
                                <label for="descrNota" class="fw-bold col-8 form-label">Descripción Nota:</label>
                                <textarea name="descrNota" class="col-4 form-control" style="height:100px;" maxlength="100" pattern="^(?=.*[a-zA-Z0-9])[\sa-zA-ZáéíóúÁÉÍÓÚñÑ0-9!@#$%^&*_+-={}?]{1,100}$"
                                required></textarea>
                            </div>
                            <input type="hidden" value="1" name="tipo">
                            <div class="pt-3"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Eliminar cuenta-->
    <div class="modal fade" id="eliminar">
        <div class="modal-dialog row">
            <div class="modal-content col-ls-12">
                <form id="formI" action="sesion.php" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <div class="col-6"><img src="img/Icon v2.png" alt="Logo" class="logoig"></div>
                        <div class="col-6 text-end"><input type="submit" value="Eliminar Cuenta" name="tipo" class="btn" id="btn1"></div>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body row">
                        <div class="esp"></div>
                            <div class="col-12">
                                <label for="pass2" class="fw-bold col-8 form-label">Contraseña:</label>
                                <input type="password" name="pass2" id ="epass" class="col-4 form-control" maxlength="10" require>
                                <a onclick="togglePasswordReg3()"><span class="material-symbols-outlined btn" id="PassIcon3">visibility_off</span></a>
                            </div>
                            <div class="esp"></div>
                    </div>
                </form>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center">
                    Copyright © Notizen 2023
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNoti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-6"><img src="img/Icon v2.png" alt="Logo" class="logoig"></div>
                    <div class="col-6 text-end"><button class="btn" id="btn1" onclick="Notification.requestPermission();">Activa Notificaciones</button></div>
                </div>
                <div class="modal-body">
                    <div class="text-center">Por favor, otorgue permiso para recibir notificaciones</div>
                </div>
            </div>
        </div>
    </div>
    <script id="cargaNoti">actualizaNoti();</script>
</body>
</html>