<?php
include('../lib/connect.php');
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['rol'])) {
	header("Location:../index.php");
}
$email=$conectar->query("SELECT * FROM usuarios WHERE email='".$_SESSION['email']."' OR num_nomina='".$_SESSION['email']."' ");
$auser=$email->fetch_array();

if(isset($_REQUEST['nombre_solicitante']))    
{   
    $id_vcns="";
    $u=$auser['nombre']." ".$auser['apellidos'];
    $fecha_registro=$_REQUEST['fecha_registro'];
    $nombre_solicitante=$_REQUEST['nombre_solicitante'];
    $departamento=addslashes($_REQUEST['departamento']);
    $num_nomina=$_REQUEST['num_nomina'];
    $puesto=addslashes(mb_convert_case($_REQUEST['puesto'],MB_CASE_TITLE, "UTF-8"));
    $fecha_ingreso=$_REQUEST['fecha_ingreso'];
    $num_dias_vcns=$_REQUEST['num_dias_vcns'];
    $periodo1=$_REQUEST['periodo1'];
    $periodo2=$_REQUEST['periodo2'];
    $num_dias_a_difrutar=$_REQUEST['num_dias_a_difrutar'];
    $dias_a_difrutar_del=$_REQUEST['dias_a_difrutar_del'];
    $dias_a_difrutar_al=$_REQUEST['dias_a_difrutar_al'];
    $regreso=$_REQUEST['regreso'];
    $dias_restantes=$_REQUEST['dias_restantes'];
    $prima_vacacional=$_REQUEST['prima_vacacional'];

    $fecha_registro = strtotime('NOW');
    $fecha_registro = date('Y-m-d',$fecha_registro);
    
 if ($conectar->query ("INSERT INTO vacaciones 
 VALUES(NULL, '$u', '$fecha_registro', '$nombre_solicitante', '$departamento', '$num_nomina',  '$puesto', '$fecha_ingreso', default, default, default, '$num_dias_a_difrutar', '$dias_a_difrutar_del', '$dias_a_difrutar_al', '$regreso', '$dias_restantes', default, default, '$prima_vacacional',default)"))
 {
        $id = mysqli_insert_id($conectar);
     
        $_SESSION['success'] = 'toastr.success("¡Permiso registrado!", "Éxito",{ "progressBar": true, "positionClass": "toast-top-center","hideMethod": "slideUp","extendedTimeOut": "700"})';
        header( "Location:home.php" );
        exit();
        mysql_close( $link );
 }
    else {
        $_SESSION['error'] = 'toastr.error("Hubo un error al registrar tu permiso de vacaciones.", "Error",{ "closeButton": true,"progressBar": true,"positionClass": "toast-top-center", "timeOut": "2000","hideMethod": "slideUp","extendedTimeOut": "700"})';
        header( "Location:home.php" );
        exit();
        mysql_close( $link );
}
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Vacaciones</title>

    <?php include('../lib/head_links.php'); ?>
</head>

<body>

    <?php include('../lib/header.php'); ?>

    <div class="contenido_solicitud">
        <div class="top">
            <h1>AVISO DE VACACIONES</h1>
            <div>
            <a href="home.php" class="btn btn-light btn-lg inicio"><i class="far fa-times-circle"></i></a>
            </div>
        </div>
        <div class="cont_form">
            <!--<form method="post" class="form-inline justify-content-center flex-lg-row" enctype="multipart/form-data">-->
            <form method="post">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Fecha:</label>
                                <input type="" name="fecha_registro" class="form-control" style="width: 88%;" readonly value="<?=date('d/m/Y')?>" tabindex="-1">
                            </div>
                            <div class="form-group">
                                <label>Número de nómina:</label>
                                <input type="number" name="num_nomina" class="form-control" style="width: 85%" readonly tabindex="-1" value="<?php echo $auser['num_nomina'];?>">
                            </div>
                            <hr class="my-4">
                            <div style="margin-bottom:40px;">
                                <h4 style=" text-align:left">DÍAS DE VACACIONES</h4>
                            </div>
                            <div class="form-group">
                                <label>Días disponibles al día de hoy:</label>
                                <input type="number" name="dias_restantes" class="form-control" style="width: 85%" placeholder="DÍAS DISPONIBLES AL DÍA DE HOY" required onkeypress="return isNumberKey(this);" tabindex="7">
                            </div>
                            <!--<div class="form-group">
                                <label>De acuerdo a la fecha de ingreso le corresponden:</label>
                                <input type="number" name="num_dias_vcns" class="form-control" style="width: 85%" placeholder="NÚMERO DE DÍAS" required onkeypress="return isNumberKey(this);">
                            </div>-->
                            <div class="form-group">
                                <label>Número de días a disfrutar:</label>
                                <input type="number" name="num_dias_a_difrutar" class="form-control" style="width: 85%" placeholder="NÚMERO DE DÍAS A DISFRUTAR" required onkeypress="return isNumberKey(this);" tabindex="7">
                            </div>
                            <div class="form-group">
                                <label>Debiendo regresar a sus labores el día:</label>
                                <input type="date" name="regreso" class="form-control" style="width: 85%" required tabindex="10">
                            </div>
                            <hr class="my-4">
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nombre del solicitante:</label>
                                <input type="text" name="nombre_solicitante" class="form-control" style="width: 85%;" value="<?php echo $auser['nombre']." ".$auser['apellidos'];?>" readonly tabindex="-1">
                            </div>
                            <div class="form-group">
                                <label>Puesto:</label>
                                <input type="text" name="puesto" class="form-control" style="width: 85%;" placeholder="Puesto" required tabindex="2">
                            </div>
                            <hr class="my-4">
                            <!--<div class="form-group">
                                <div style="margin-bottom:40px">
                                    <h4 style=" text-align:center">&nbsp;</h4>
                                </div>
                                <label>Por el periodo:</label>
                                <input type="number" name="periodo1" class="form-control" style="width: 85%" placeholder="PERIODO" required onkeypress="return isNumberKey(this);">
                            </div>-->
                            <div class="form-group" style="margin-bottom:40px;">
                                <div class="col-lg-4 col-lg-offset-2" style="background-color:#fff">
                                    <h1>&nbsp;</h1>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-lg-offset-2" style="background-color:#fff">
                                    <h1>&nbsp;</h1>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Del día:</label>
                                <input type="date" name="dias_a_difrutar_del" class="form-control" style="width: 85%" required tabindex="8">
                            </div><br>
                            <div class="form-group">
                                <div class="col-lg-4 col-lg-offset-2" style="background-color:#fff">
                                    <h1>&nbsp;</h1>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label>Por el periodo:</label>
                                <input type="number" name="periodo_restantes1" class="form-control" style="width: 85%" placeholder="PERIODO" required>
                            </div>-->
                            <hr class="my-4">
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Departamento:</label>
                                <select class="form-control" name="departamento" required style="width:85%; cursor:pointer;" tabindex="1">
                                    
                                    <option value="" selected disabled>Selecciona una opción...</option>
                                    <option value="ALMACEN DE MATERIA PRIMA">ALMACEN MATERIA PRIMAL</option>
                                    <option value="APT">APT</option>
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
                                    <option value="MERCADOTECNIA>MERCADOTECNIA</option>
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
                                    
                                    <option data-divider="true"></option>
                                    <option value="AXONE">AXONE</option>
                                    <option value="BÍAS">BÍAS</option>
                                   
                                    <option data-divider="true"></option>
                                    <option value="LINEA GRANDE">LINEA GRANDE</option>
                                    <option value="LINEA MACHOS MAQUINADO">LINEA MACHOS MAQUINADO</option>
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
                            <div class="form-group">
                                <label>Fecha de ingreso:</label>
                                <input type="date" name="fecha_ingreso" class="form-control" style="width: 85%" required tabindex="6">
                            </div>
                            <hr class="my-4">
                            <!--<div class="form-group">
                                <label>&nbsp;</label>
                                <input type="number" name="periodo2" class="form-control" style="width: 85%" required placeholder="PERIODO" onkeypress="return isNumberKey(this);">
                            </div>-->
                            <div class="form-group" style="margin-bottom:40px;">
                                <div class="col-lg-4 col-lg-offset-2" style="background-color:#fff">
                                    <h1>&nbsp;</h1>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-lg-offset-2" style="background-color:#fff">
                                    <h1>&nbsp;</h1>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Al día:</label>
                                <input type="date" name="dias_a_difrutar_al" class="form-control" style="width: 85%" required tabindex="9">
                            </div><br>
                            <div class="form-group">
                                <div class="col-lg-4 col-lg-offset-2" style="background-color:#fff">
                                    <h1>&nbsp;</h1>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label>&nbsp;</label>
                                <input type="number" name="periodo_restantes2" class="form-control" style="width: 85%" placeholder="PERIODO" required onkeypress="return isNumberKey(this);">
                            </div>-->
                            <hr class="my-4">
                        </div>
                        <div class="col-sm-12">
                            <div style="margin-bottom:40px;">
                                <h4 style=" text-align:left">PRIMA DE VACACIONES</h4>
                            </div>
                            <div class="form-group">
                                <label>Prima correspondiente:</label>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <input type="number" name="prima_vacacional" id="prima_vacacional" class="form-control" placeholder="PRIMA DE VACACIONES" step='0.01' required tabindex="11">
                                    </div>
                                    <label for="prima_vacacional" class="col-form-label col-sm-6" style="font-weight:normal">% pagar por concepto de vacaciones según antigüedad sobre los días a disfrutar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br />
                    <div class="save">
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success btn-block" tabindex="12">Guardar</button>
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
