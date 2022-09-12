<?php
include( '../lib/connect.php' );
session_start();
$email = $conectar->query( "SELECT * FROM usuarios WHERE email='".$_SESSION['email']."' OR num_nomina='".$_SESSION['email']."' " );
$auser = $email->fetch_assoc();

if (!isset($_SESSION['email']) && !isset($_SESSION['rol'])) {
	header("Location:../index.php");
}

if ( isset( $_REQUEST['nombre_solicitante'] ) )     {

    $id_es = "";
    $u = $auser['nombre']." ".$auser['apellidos'];
    $fecha_creacion = "";
    $tipo_empleado = "Sindicalizado";

    $nombre_solicitante =$_REQUEST['nombre_solicitante'];
    $departamento =$_REQUEST['departamento'];
    $num_nomina = $_REQUEST['num_nomina'];
    $hora_salida = $_REQUEST['hora_salida'];
    $fecha_salida = $_REQUEST['fecha_salida'];

    $hora_entrada = $_REQUEST['hora_entrada'];
    $fecha_entrada = $_REQUEST['fecha_entrada'];
    $inasistencia_del = $_REQUEST['inasistencia_del'];
    $inasistencia_al = $_REQUEST['inasistencia_al'];
    $goce_sueldo =$_REQUEST['goce_sueldo'];
    $observaciones = addslashes(mb_convert_case($_REQUEST['observaciones'],MB_CASE_UPPER, "UTF-8"));

    if ( $conectar->query ( "INSERT INTO entrada_salida VALUES(NULL, '$u', NOW(), '$tipo_empleado', '$nombre_solicitante', '$departamento',  '$num_nomina', '$hora_salida', '$fecha_salida', '$hora_entrada', '$fecha_entrada', '$inasistencia_del', '$inasistencia_al', '$goce_sueldo', '$observaciones',default)" ) ) {
        $id = mysqli_insert_id( $conectar );
        $_SESSION['success'] = 'toastr.success("¡Permiso registrado!", "Éxito",{ "progressBar": true, "positionClass": "toast-top-center","hideMethod": "slideUp","extendedTimeOut": "700"})';
        header( "Location:home.php" );
        exit();
        mysql_close( $link );

    } else {
        $_SESSION['error'] = 'toastr.error("Hubo un error al registrar tu permiso.", "Error",{  "closeButton": true,"progressBar": true,"positionClass": "toast-top-center", "timeOut": "2000",,"hideMethod": "slideUp","extendedTimeOut": "800"})';
        header( "Location:home.php" );
        exit();
        mysql_close( $link );
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Permiso - Sindicalizado</title>
    
    <?php include('../lib/head_links.php'); ?>
</head>

<body>

    <?php include( '../lib/header.php' );
?>

    <div class="contenido_solicitud">
        <div class="top">
            <h1>AUTORIZACIÓN DE INASISTENCIA, ENTRADA O SALIDA<br>
                DE LAS INSTALACIONES FUERA DE HORARIO</h1>
            <a href="home.php" class="btn btn-light btn-lg inicio"><i class="far fa-times-circle"></i></a>
            </div>
        </div>
        <div class="cont_form">
            <form method="post" enctype="multipart/form-data">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nombre del solicitante:</label>
                                <input type="text" name="nombre_solicitante" class="form-control" style="width: 85%; text-transform: capitalize;" value="<?php echo $auser['nombre']." ".$auser['apellidos'];?>" readonly tabindex="-1">
                            </div>
                            <hr class="my-4">
                            <div class="form-group">
                                <label>Se autoriza la SALIDA a las:</label>
                                <input type="time" name="hora_salida" class="form-control" style="width: 85%" tabindex="2">
                            </div>
                            <div class="form-group">
                                <label>Se autoriza ENTRADA de</label>
                                <input type="time" name="hora_entrada" class="form-control" style="width: 85%" tabindex="7">
                            </div>
                            <div class="form-group">
                                <label>Se autoriza la INANSISTENCIA a las:</label>
                                <input type="date" name="inasistencia_del" class="form-control" style="width: 85%" tabindex="9">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Departamento</label>
                                <select class="form-control" name="departamento" required style="width:85%; cursor:pointer;" tabindex="1">
                                    <option value="LINEA MACHOS MAQUINADO">LINEA MACHOS MAQUINADO</option>
                                    <option value="LINEA GRANDE">LINEA GRANDE</option>
                                    <option value="MANUFACTURA">MANUFACTURA</option>
                                    <option value="LINEA FUNDIDO CHICA MAQUINADO">LINEA FUNDIDO CHICA MAQUINADO</option>
                                    <option value="ALMACEN DE PRODUCTO TERMINADO">ALMACEN DE PRODUCTO TERMINADO</option>
                                    <option value="LINEA FUNDIDO CHICA ENSAMBLE">LINEA FUNDIDO CHICA ENSAMBLE</option>
                                    <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                    <option value="SOLDADURA">SOLDADURA</option>
                                    <option value="LINEA FORJADO  SAB MAQUINADO">LINEA FORJADO  SAB MAQUINADO</option>
                                    <option value="LINEA API 6D ENSAMBLE">LINEA API 6D ENSAMBLE</option>
                                    <option value="MAQUINADO DE MISCELANEOS">MAQUINADO DE MISCELANEOS</option>
                                    <option value="LINEA FORJADO  SAB ENSAMBLE">LINEA FORJADO  SAB ENSAMBLE</option>
                                    <option value="LINEA MACHOS ENSAMBLE">LINEA MACHOS ENSAMBLE</option>
                                    <option value="ALMACEN DE MATERIA PRIMA INVAL">ALMACEN DE MATERIA PRIMA INVAL</option>
                                    <option value="PND">PND</option>
                                    <option value="TALLER DE HERRAMIENTAS">TALLER DE HERRAMIENTAS</option>
                                    <option value="LOGISTICA">LOGISTICA</option>
                                    <option value="LINEA API 6D MAQUINADO">LINEA API 6D MAQUINADO</option>
                                    <option value="ALMACEN DE HERRAMIENTAS">ALMACEN DE HERRAMIENTAS</option>
                                    <option value="BARRAS Y CORTE">BARRAS Y CORTE</option>

                                </select>
                            </div>
                            <hr class="my-4">
                            <div class="form-group">
                                <label>Del día:</label>
                                <input type="date" name="fecha_salida" class="form-control" style="width: 85%" tabindex="3">
                            </div>
                            <div class="form-group">
                                <label>Del día:</label>
                                <input type="date" name="fecha_entrada" class="form-control" style="width: 85%" tabindex="8">
                            </div>
                            <div class="form-group">
                                <label>Al día:</label>
                                <input type="date" name="inasistencia_al" class="form-control" style="width: 85%" tabindex="10">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Número de nómina</label>
                                <input type="number" name="num_nomina" class="form-control" style="width: 85%" value="<?php echo $auser['num_nomina']?>" readonly tabindex="-1">
                            </div>
                            <hr class="my-4">
                            <div class="form-group">
                                <label>Goce de sueldo</label><br>
                                <label class="radio-inline" style='cursor:pointer; width: 40%; font-weight: normal;' tabindex="4">
                                    <input type="radio" name="goce_sueldo" value="Si" required style='cursor:pointer;'> Si
                                </label>
                                <label class="radio-inline" style='cursor:pointer; width: 40%; font-weight: normal;' tabindex="5">
                                    <input type="radio" name="goce_sueldo" value="No" style='cursor:pointer;'> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group obs">
                                <label for="txt">Observaciones</label>
                                <textarea name="observaciones" class="form-control" id="txt" rows="4" cols="20" style="resize: none;" tabindex="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="save">
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success btn-block" tabindex="11">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
</body>

</html>

<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
