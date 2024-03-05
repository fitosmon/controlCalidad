<?php
include "conexiondb.php";

$id_usuario = $_SESSION["id_usuario"];

$sql = "SELECT notificacion.id_tarea, fecha, nombre_tarea, id_compartir 
        FROM notificacion 
        JOIN tarea ON notificacion.id_tarea = tarea.id_tarea
        WHERE notificacion.id_usuario = '$id_usuario';";

if(($result = $conexion->query($sql)) === FALSE) {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

// Realizar la consulta a la base de datos para obtener las notificaciones
$resultado = mysqli_query($conexion, $sql);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Array para almacenar las notificaciones
    $notificaciones = array();

    // Recorrer los resultados y agregar las notificaciones al array
    while ($fila = $resultado->fetch_assoc()) {
        $noti = array(
            "nombre_tarea" => $fila["nombre_tarea"],
            "fecha" => $fila["fecha"],
            "compartida" => $fila["id_compartir"]
        );
        $notificaciones[] = $noti;
    }

    // Generar el código JavaScript para los eventos del calendario
    $eventos_js = "";
    foreach ($notificaciones as $noti) {
        $nombre_tarea = $noti["nombre_tarea"];
        $fecha = $noti["fecha"];
        $com = $noti["compartida"];
        if($com == 0){$link = 'tareadetalle.php';} else {$link = 'compartida.php';}
        
        $evento = "{ title: 'Notificación: $nombre_tarea',
                     start: '$fecha',
                     url: '$link' },";
        $eventos_js .= $evento;
    }

    // Imprimir el código JavaScript
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: [$eventos_js]
                });
                calendar.render();
            });
        </script>";
}

?>