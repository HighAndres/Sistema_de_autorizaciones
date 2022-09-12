<?php
include( '../lib/connect.php' );
session_start();
$email = $conectar->query( "SELECT * FROM usuarios WHERE email='".$_SESSION['email']."' OR num_nomina='".$_SESSION['email']."' " );
$auser = $email->fetch_assoc();

if (!isset($_SESSION['email']) && !isset($_SESSION['rol'])) {
	header("Location:../index.php");
}

if ( isset( $_REQUEST['nombre_solicitante'] ) ) {

    $id_es = "";
    $u = $auser['nombre']." ".$auser['apellidos'];
    $fecha_creacion = "";
    $tipo_empleado = "Administrativo";

    $nombre_solicitante = ucwords( $_REQUEST['nombre_solicitante'] );
    $departamento = ucwords( $_REQUEST['departamento'] );
    $num_nomina = $_REQUEST['num_nomina'];
    $hora_salida = $_REQUEST['hora_salida'];
    $fecha_salida = $_REQUEST['fecha_salida'];

    $hora_entrada = $_REQUEST['hora_entrada'];
    $fecha_entrada = $_REQUEST['fecha_entrada'];
    $inasistencia_del = $_REQUEST['inasistencia_del'];
    $inasistencia_al = $_REQUEST['inasistencia_al'];
    $goce_sueldo = "NO";
    $observaciones = addslashes(mb_convert_case( $_REQUEST['observaciones'],MB_CASE_UPPER, "UTF-8"));

    if ( $conectar->query ( "INSERT INTO entrada_salida VALUES(NULL,'$u', NOW(), '$tipo_empleado', '$nombre_solicitante', '$departamento',  '$num_nomina', '$hora_salida', '$fecha_salida', '$hora_entrada', '$fecha_entrada', '$inasistencia_del', '$inasistencia_al', '$goce_sueldo', '$observaciones',default)" ) ) {
        $id = mysqli_insert_id( $conectar );
        $_SESSION['success'] = 'toastr.success("¡Permiso registrado!", "Éxito",{ "progressBar": true, "positionClass": "toast-top-center","hideMethod": "slideUp","extendedTimeOut": "700"})';
        header( "Location:home.php" );
        exit();
        mysql_close( $link );

    } else {
        $_SESSION['error'] = 'toastr.error("Hubo un error al registrar tu permiso.", "Error",{ "closeButton": true,"progressBar": true,"positionClass": "toast-top-center", "timeOut": "2000","hideMethod": "slideUp","extendedTimeOut": "800"})';
        header( "Location:home.php" );
        exit();
        mysql_close( $link );
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Permiso - Administrativo</title>
    
    <?php include('../lib/head_links.php'); ?>
</head>

<body>

    <?php include( '../lib/header.php' );?>

    <div class="contenido_solicitud">
        <div class="top">
            <h1>AUTORIZACIÓN DE INASISTENCIA, ENTRADA O SALIDA<br>
                DE LAS INSTALACIONES FUERA DE HORARIO</h1>
            <div>
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
                                <input type="time" name="hora_salida" class="form-control" style="width: 85%" tabindex="4">
                            </div>
                            <div class="form-group">
                                <label>Se autoriza ENTRADA a las:</label>
                                <input type="time" name="hora_entrada" class="form-control" style="width: 85%" tabindex="6">
                            </div>
                            <div class="form-group">
                                <label>Se autoriza la INANSISTENCIA :</label>
                                <input type="date" name="inasistencia_del" class="form-control" style="width: 85%" tabindex="8">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Departamento</label>
                                <select class="form-control" name="departamento" required style="width:85%; cursor:pointer;" tabindex="1">
                                    <option value="" selected disabled>Selecciona una opción...</option>
                                    <option value="ALMACEN DE MATERIA PRIMA">ALMACEN MATERIA PRIMAL</option>
                                    <option value="ALMACEN DE PRODUCTO TERMINADOL">APT</option>
                                    <option value="DIRECCION COMERCIAL">DIRECCION COMERCIAL</option>
                                    <option value="DIRECCION ADMINISTRACION Y FINANZAS">D.ADMINISTRACION Y FINANZAS</option>
                                    <option value="DIRECCION DE INGENERIA R&D">D.INGENERIA R&D</option>
                                    <option value="DIRECCION DE OPERACIONES">D.OPERACIONES</option>
                                    <option value="DIRECCION ESTRATEGICA">D.ESTRATEGICA</option>
                                    <option value="DIRECCION GENERAL">D.GENERAL</option>
                                    <option value="GERANCIA DE VENTAS INTERNACIONALES">G.VENTAS INTERNACIONALES</option>
                                    <option value="GERENCIA ADMINISTRATIVA">G.ADMINISTRATIVA</option>
                                    <option value="GERENCIA DE ABASTECIMIENTO Y ADQUISIONES">G.ABASTECIMIENTO Y ADQUISIONES</option>
                                    <option value="GERENCIA DE ADMINISTRACION DE CONTRATOS">G.ADMINISTRACION DE CONTRATOS</option>
                                    <option value="GERENCIA DE LOGISTICA">G.LOGISTICA</option>
                                    <option value="GERENCIA DE PROCESOS ESPECIALES">G.PROCESOS ESPECIALES</option>
                                    <option value="GERENCIA DE PRODUCCION">G.PRODUCCION</option>
                                    <option value="GERENCIA DE SERVICIOS TECNICOS">G.SERVICIOS TECNICOS</option>
                                    <option value="GERENCIA DE TALENTO">G.TALENTO</option>
                                    <option value="GERENCIA DE VENTAS DEL SURESTE">G.VENTAS DEL SURESTE</option>
                                    <option value="GERENCIA DE VENTAS INTERNACIONALES">G.VENTAS INTERNACIONALES</option>
                                    <option value="GERENCIA DE VENTAS NACIONALES">G.VENTAS NACIONALES</option>
                                    <option value="JEFATURA DE ADMINISTRACION DE PERSONAL">J.ADMINISTRACION DE PERSONAL</option>
                                    <option value="JEFATURA DE ASEGURAMIENTO DE CALIDAD">J.ASEGURAMIENTO DE CALIDAD</option>
                                    <option value="JEFATURA DE COMPRAS ESTRATEGICAS">J.COMPRAS ESTRATEGICAS</option>
                                    <option value="JEFATURA DE CONTABILIDAD">J.CONTABILIDAD</option>
                                    <option value="JEFATURA DE COSTOS">J.COSTOS</option>
                                    <option value="JEFATURA DE CREDITO Y COBRANZA">J.CREDITO Y COBRANZA</option>
                                    <option value="JEFATURA DE ING DEL PRDUCTO">J.ING DEL PRDUCTO</option>
                                    <option value="JEFATURA DE INGENERIA DE MANUFACTURA">J.INGENERIA DE MANUFACTURA</option>
                                    <option value="JEFATURA DE MANTENIMIENTO">J.MANTENIMIENTO</option>
                                    <option value="JEFATURA DE PLANEACION Y CONTROL DE LA PRODUCCION">J.PLANEACION CONTROL DE LA PRODUCCION</option>
                                    <option value="JEFATURA VENTAS FIRMAS INGENIERIA">J.VENTAS FIRMAS INGENIERIA</option>
                                    <option value="JEFATURA DE QHSE">J.QHSE</option>
                                    <option value="JEFATURA DE SISTEMAS">J.SISTEMAS</option>
                                    <option value="JEFATURA DE TESORERIA">J.TESORERIA</option>
                                    <option value="JEFATURA VENTAS ACTUADORES">J.VENTAS ACTUADORES</option>
                                    <option value="JEFATURA VENTAS C & SA">J.VENTAS C & SA</option>
                                    <option value="JEFATURA VENTAS FIRMAS INGENIERIA">JEFATURA VENTAS FIRMAS INGENIERIA</option>
                                    <option value="JEFATURA VENTAS GOBIERNO">J.VENTAS GOBIERNO</option>
                                    <option value="JEFATURA VENTAS PROYECTOS">JEFATURA VENTAS PROYECTOS</option>
                                    <option value="AXONE">AXONE</option>
                                    <option value="BÍAS">BÍAS</option>
                                    <option data-divider="true"></option>
                                </select>
                            </div>
                            <hr class="my-4">
                            <div class="form-group">
                                <label>Del día:</label>
                                <input type="date" name="fecha_salida" class="form-control" style="width: 85%" tabindex="5">
                            </div>
                            <div class="form-group">
                                <label>Del día:</label>
                                <input type="date" name="fecha_entrada" class="form-control" style="width: 85%" tabindex="7">
                            </div>
                            <div class="form-group">
                                <label>Al día:</label>
                                <input type="date" name="inasistencia_al" class="form-control" style="width: 85%" tabindex="9">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Número de nómina</label>
                                <input type="number" name="num_nomina" class="form-control" style="width: 85%" value="<?php echo $auser['num_nomina']?>" readonly  tabindex="-1">
                            </div>
                            <hr class="my-4">
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
                        <button type="submit" class="btn btn-success btn-block" tabindex="10">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
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
