<?php
include('../lib/connect.php');

session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['rol'])) {
	header("Location:../index.php");
}

$key = '5973C777%B7673309895AD%FC2BD1962C1062B9?3890FC277A04499¿54D18FC13677';

$email=$conectar->query("SELECT * FROM usuarios WHERE email='".$_SESSION['email']."' OR num_nomina='".$_SESSION['email']."' ");
$auser=$email->fetch_assoc();

//ARRAY TODOS LOS REGISTROS    
$permisos=$conectar->query("SELECT * FROM entrada_salida WHERE user='".$auser['nombre']." ".$auser['apellidos']."' ORDER BY fecha_creacion DESC");
$arrayr=$permisos->fetch_assoc();
$nr=$permisos->num_rows;

date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, 'es_MX');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitudes de permisos</title>

    <?php include('../lib/head_links.php'); ?>    
</head>

<body>
    <?php include('../lib/header.php'); ?>

    <div class="cont">
        <div class="encabezado1">
            <h3>Solicitudes de permisos de entradas y salidas</h3>
            <a href="home.php" class="btn btn-light btn-lg inicio"><i class="fas fa-home"></i></a>
        </div>
        <div class="encabezado2">
            <h3>Nota: No es necesario imprimir el permiso una vez autorizado.</h3>
        </div>
        <div class="tabla">
            <table id="tablax" class="display table-striped table-bordered dataTable no-footer">
                <thead>
                    <th>FECHA DE CREACIÓN</th>
                    <th>FECHA Y HORA DE SALIDA</th>
                    <th>FECHA Y HORA DE ENTRADA</th>
                    <th>FECHAS DE INASISTENCIA</th>
                    <th>ESTATUS</th>
                    <th>IMPRIMIR</th>
                </thead>

                <tbody>
                    <?php 
            if($nr>0){
                do{
            echo "<td>".strftime("%d/%b/%Y",strtotime($arrayr['fecha_creacion']))."</td>";
            if($arrayr['fecha_salida']>0 && $arrayr['hora_salida']>0) {
                echo "<td>".strftime("%d/%b/%Y",strtotime($arrayr['fecha_salida']))."<br>"
                .date('H:i', strtotime($arrayr['hora_salida']))."</td>";
                    }else{
                    echo "<td> </td>"; 
                    } 
            if($arrayr['fecha_entrada']>0 && $arrayr['hora_entrada']>0) { 
                echo "<td>".strftime("%d/%b/%Y",strtotime($arrayr['fecha_entrada']))."<br>"
                .date('H:i', strtotime($arrayr['hora_entrada']))."</td>";
                    }else{
                        echo "<td> </td>";
                        }
            if($arrayr['inasistencia_del']>0 && $arrayr['inasistencia_al']>0) { 
                echo "<td> Del: ".strftime("%d/%b/%Y",strtotime($arrayr['inasistencia_del'])). 
                "<br>&nbsp;&nbsp;Al: ".strftime("%d/%b/%Y",strtotime($arrayr['inasistencia_al']))."</td>";
                    }else{
                        echo "<td> </td>";
                        }
            echo "<td>".$arrayr['estatus']."</td>";
            if($arrayr['estatus']=='Autorizada') {
                echo "<td><a href='../pdf/pdf_permiso_dia.php?refd=".md5($key.$arrayr['id_es'])."' target='_blank' class='btn-success btn-sm'><i class='fas fa-print'></i></a></td></tr>";
            } else {
                echo "<td></td></tr>";
            }
                    
            }while($arrayr=$permisos->fetch_assoc());
            }else{ 
             echo "<tr><td colspan=12>No hay solicitudes de permisos registrados</td></tr>";
            }?>
                </tbody>
            </table>
        </div>
    </div>
<?php include('../lib/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</body>

</html>

<!-- -----------------TABLA----------------- -->
<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous">
</script>
<!-- DATATABLES -->
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
</script>
<!-- BOOTSTRAP -->
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js">
</script>
<!-- TABLE -->
<script>
    $(document).ready(function() {
        $('#tablax').DataTable({
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "No hay ningún permiso registrado",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
            },
            scrollY: 400,
            scrollCollapse: true,
            lengthMenu: [
                [5, 10, -1],
                [5, 10, "Todo"]

            ],
            "aaSorting": [],
        });
    });
</script>
