<?php
    session_start();
    ob_start();
    include "conexiondb.php";
    date_default_timezone_set('America/Mexico_City');
     
    $id_usuario = $_SESSION['id_usuario'];

    /* SOLICITAR TODAS LAS TAREAS SIN COMPLETAR DEL USUARIO */
    $sql = "SELECT id_tarea, nombre_tarea FROM tarea WHERE id_usuario = '$id_usuario' AND completada = 0";
    $resultado_tarea = $conexion->query($sql);

    if(($resultado_tarea = $conexion->query($sql)) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }


    while($tarea = mysqli_fetch_assoc($resultado_tarea)){
        $idTarea = $tarea['id_tarea'];
        $nombreTarea = $tarea['nombre_tarea'];

        $consultaTarea = "SELECT fecha, hora FROM notificacion WHERE id_tarea ='$idTarea'";
        $resultadoNotificacion = $conexion->query($consultaTarea);



        while ($notificacion = mysqli_fetch_assoc($resultadoNotificacion)) {
            $horaActual = date('H:i');
            $fechaActual = date('Y-m-d');
            $fechaNotificacion = $notificacion['fecha'];
            $horaNotificacion = date('H:i', strtotime($notificacion['hora']));
        
            if ( strtotime($fechaNotificacion)>strtotime($fechaActual) || (strtotime($fechaNotificacion)==strtotime($fechaActual) && strtotime($horaNotificacion)>strtotime($horaActual)) ) {
                echo'
                    console.log(notificacionPush("'.$nombreTarea.'", "'.$fechaNotificacion.'T'.$horaNotificacion.'"));
                ';
            }
        }

    }

?>