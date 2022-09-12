<?php
include('../lib/connect.php');

session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['rol'])) {
	header("Location:../index.php");
} else {
    if($_SESSION['rol'] != 1){
        header("Location:home.php");
    }
}

if(isset($_REQUEST['cerrar'])){
	session_destroy();
	header("Location:../index.php");
}

$key = '5973C777%B7673309895AD%FC2BD1962C1062B9?3890FC277A04499¿54D18FC13677';

//ARRAY TODOS LOS REGISTROS 
$permisos=$conectar->query("SELECT * FROM vacaciones WHERE estatus='Pendiente' ORDER BY fecha_registro DESC");
$nr=$permisos->num_rows;
$arrayr=$permisos->fetch_assoc();

//ARRAY OBTENER ID
if(isset($_REQUEST['folio'])){ 
$qaut=$conectar->query("SELECT * FROM vacaciones WHERE MD5(concat('".$key."',id_vcns))='".$_REQUEST['folio']."'");
$aaut=$qaut->fetch_assoc();
}

                               
if(isset($_POST['editar'])){
    $id = $_GET['id'];
    $estatus=$_POST['estatus'];
    
    $conectar->query("UPDATE vacaciones SET estatus='$estatus' WHERE id_vcns= '$id'");
    $_SESSION['success']='toastr.success("¡Se ha actualizado el registro!", "Éxito",{ "progressBar": true, "positionClass": "toast-top-center","hideMethod": "slideUp","extendedTimeOut": "700"})';
    header("Location:autorizar_vacaciones.php");
    exit();
}
                   
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, 'es_MX');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Autorización de permisos</title>

    <?php include('../lib/head_links.php'); ?>
</head>

<body>
    <?php include('../lib/header.php'); 
          include('../jquery/alerts.php');?>

    <div class="cont">
        <div class="encabezado">
            <h3>Autorizar permisos de vacaciones</h3>
            <a href="home.php" class="btn btn-light btn-lg inicio"><i class="fas fa-home"></i></a>
        </div>
        <div class="tabla">
            <table id="tablax" class="display table-striped table-bordered dataTable">
                <thead>
                    <th>USUARIO</th>
                    <th>FECHA DE EXPEDICIÓN</th>
                    <th>DÍAS A DISFRUTAR</th>
                    <th>DEL</th>
                    <th>AL</th>
                    <th>REGRESA A SUS LABORES EL DÍA</th>
                    <th>ESTATUS</th>
                    <th>CAMBIAR ESTATUS</th>
                    <th>VER PERMISO</th>
                </thead>

                <tbody>
                    <?php if($nr>0){
                    do{ ?>
                    <!-- Ventana Editar Registros CRUD -->
                    <div class="modal fade" id="edit_<?php echo $arrayr['id_vcns']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">CAMBIAR ESTATUS DE PERMISO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <form method="POST" action="autorizar_vacaciones.php?id=<?php echo $arrayr['id_vcns']; ?>">
                                            <div class="row form-group">
                                                <div class="col-sm-2">
                                                    <label class="control-label" style="position:relative; top:7px;">Usuario:</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="estatus" value="<?php echo $arrayr['user']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-2">
                                                    <label class="control-label" style="position:relative; top:7px;">Estatus:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="estatus" required>
                                                        <?php $estatus = array('Pendiente','Rechazada', 'Autorizada'); 
                                                    sort($estatus, SORT_NATURAL | SORT_FLAG_CASE);
                                                    $selected= $arrayr['estatus'];
                                                    foreach($estatus as $estatus){
                                                    echo "<option value=\"$estatus\"";  
                                                    if ($estatus==$arrayr['estatus']) { 
                                                    echo "selected"; } 
                                                    echo ">$estatus</option>";}?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1" style="margin: 0; padding:5px;">
                                                    <a tabindex="0" class="btn btn-sm btn-link btn-circle" role="button" data-toggle="popover" data-trigger="focus" title="Cambio de estatus" data-content="Una vez dando clic en el botón de 'Guardar', ya no se podrá cambiar el estatus del permiso." style="padding:0"><i class="far fa-question-circle" style=""></i></a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-right:auto">Cancelar</button>
                                    <button type="submit" name="editar" class="btn btn-success">Guardar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <tr>
                        <td> <?php echo $arrayr['user'];?> </td>
                        <td><?php echo strftime("%d/%b/%Y",strtotime($arrayr['fecha_registro']));?></td>
                        <td>
                            <?php echo $arrayr['num_dias_a_difrutar']; ?>
                        </td>
                        <td>
                            <?php echo strftime("%d/%b/%Y",strtotime($arrayr['dias_a_difrutar_del']));?>
                        </td>
                        <td>
                            <?php echo strftime("%d/%b/%Y",strtotime($arrayr['dias_a_difrutar_al']));?></td>
                        <td>
                            <?php echo strftime("%d/%b/%Y",strtotime($arrayr['regreso']));?></td>
                        <td> <?php echo $arrayr['estatus']; ?></td>
                        <td><a href="#edit_<?php echo $arrayr['id_vcns']; ?>" class="btn btn-success btn-sm" data-toggle="modal"><i class="fas fa-user-edit"></i></a></td>
                        <td><a href="../pdf/pdf_vacaciones.php?refv=<?php echo md5($key.$arrayr['id_vcns']); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    <?php }while($arrayr=$permisos->fetch_assoc());
            }else{ 
             echo "<tr><td colspan=12>No hay ningún permiso registrado</td></tr>";
            }?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include('../lib/footer.php'); ?>


</body>

</html>

<!-- -----------------TABLA----------------- -->
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
                "sEmptyTable": "No hay ningún registro",
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
            scrollY: 450,
            scrollCollapse: true,
            lengthMenu: [
                [5, 10, -1],
                [5, 10, "Todo"]

            ],
            "aaSorting": [],
        });
    });

</script>


<script>
    $(function() {
        $('[data-toggle="popover"]').popover({})
    })

</script>
