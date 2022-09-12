<?php
include('../lib/connect.php');

session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['rol'])) {
	header("Location:../index.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Home</title>
    <?php include('../lib/head_links.php'); ?>

</head>

<body style="background-color:#E0E0E0">
    
    <?php include('../lib/header.php');
    include('../jquery/alerts.php');?>

    <!-- Modal tipo de empleado -->
    <div class="modal fade" id="autorizaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">AUTORIZAR PERMISOS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <a class="btn btn-success btn-lg" href="autorizar_dias.php">Permisos de entradas y salidas</a><br><br>
                        <a class="btn btn-success btn-lg" href="autorizar_vacaciones.php">Vacaciones</a>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal tipo de empleado -->
    <div class="modal fade" id="tipoEmpleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">EMPLEADO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <a class="btn btn-success btn-lg" href="form_administrativo.php">Administrativo</a><br><br>
                        <a class="btn btn-success btn-lg" href="form_sindicalizado.php">Sindicalizado</a>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal históricos -->
    <div class="modal fade" id="historicos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">HISTÓRICO DE PERMISOS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <a class="btn btn-success btn-lg" href="historico_dias.php">Permisos de entradas y salidas</a><br><br>
                        <a class="btn btn-success btn-lg" href="historico_vacaciones.php">Vacaciones</a>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal solicitudes -->
    <div class="modal fade" id="solicitudes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">MIS SOLICITUDES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <a class="btn btn-success btn-lg" href="solicitudes_dias.php">Permisos de entradas y salidas</a><br><br>
                        <a class="btn btn-success btn-lg" href="solicitudes_vacaciones.php">Vacaciones</a>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


   <?php if($auser['rol_id']==1) { ?>
    <!------------------------------ VISTA GERENTE/DIRECTOR ------------------------------>
    <div class="head_cab">
        <h2>MENÚ PRINCIPAL</h2>
    </div>

    <div class="wrap">

        <a href="#" data-toggle="modal" data-target="#autorizaciones">
            <div class="opc">
                <div class="panel1">
                    <h1>Autorizar permisos</h1>
                </div>
                <div class="ico">
                    <img src="../img/checklist_102320.png" alt="Autorización" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="#" data-toggle="modal" data-target="#solicitudes">
            <div class="opc">
                <div class="panel1">
                    <h1>Mis solicitudes</h1>
                </div>
                <div class="ico">
                    <img src="../img/user.png" alt="Autorización" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="#" data-toggle="modal" data-target="#tipoEmpleado">
            <div class="opc">
                <div class="panel1">
                    <h1>Permiso para entradas<br> y salidas</h1>
                </div>
                <div class="ico">
                    <img src="../img/notes_102334.png" alt="Permiso" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="vacaciones.php">
            <div class="opc">
                <div class="panel1">
                    <h1>Vacaciones</h1>
                </div>
                <div class="ico">
                    <img src="../img/cv_102350.png" alt="Aviso">
                </div>
            </div>
        </a>
    </div>


   <?php } elseif($auser['rol_id']==2) { ?>
   <!------------------------------ VISTA RECURSOS HUMANOS ------------------------------>
    <div class="head_cab">
        <h3>Menú principal</h3>
    </div>
    <div class="wrap">
        <a href="#" data-toggle="modal" data-target="#historicos">
            <div class="opc">
                <div class="panel1">
                    <h1>Histórico de permisos</h1>
                </div>
                <div class="ico">
                    <img src="../img/find_102325.png" alt="Autorización" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="#" data-toggle="modal" data-target="#solicitudes">
            <div class="opc">
                <div class="panel1">
                    <h1>Mis solicitudes</h1>
                </div>
                <div class="ico">
                    <img src="../img/user.png" alt="Autorización" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="#" data-toggle="modal" data-target="#tipoEmpleado">
            <div class="opc">
                <div class="panel1">
                    <h1>Permiso para entradas<br> y salidas</h1>
                </div>
                <div class="ico">
                    <img src="../img/notes_102334.png" alt="Permiso" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="vacaciones.php">
            <div class="opc">
                <div class="panel1">
                    <h1>Vacaciones</h1>
                </div>
                <div class="ico">
                    <img src="../img/cv_102350.png" alt="Aviso">
                </div>
            </div>
        </a>
    </div>

    <?php } elseif($auser['rol_id']==3) { ?>
    <!------------------------------ VISTA USUARIO ------------------------------>
    <div class="head_cab">
        <h3>Menú principal</h3>
    </div>
    <div class="wrap">

        <a href="#" data-toggle="modal" data-target="#solicitudes">
            <div class="opc">
                <div class="panel1">
                    <h1>Mis solicitudes</h1>
                </div>
                <div class="ico">
                    <img src="../img/user.png" alt="Autorización" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="#" data-toggle="modal" data-target="#tipoEmpleado">
            <div class="opc">
                <div class="panel1">
                    <h1>Permiso para entradas<br> y salidas</h1>
                </div>
                <div class="ico">
                    <img src="../img/notes_102334.png" alt="Permiso" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="vacaciones.php">
            <div class="opc">
                <div class="panel1">
                    <h1>Vacaciones</h1>
                </div>
                <div class="ico">
                    <img src="../img/cv_102350.png" alt="Aviso">
                </div>
            </div>
        </a>
    </div>

    <?php } else { ?>
    <!------------------------------ VISTA ADMINISTRADOR ------------------------------>
    <div class="head_cab">
        <h3>Menú principal Admin</h3>
    </div>
    <div class="wrap">

        <a href="#" data-toggle="modal" data-target="#tipoEmpleado">
            <div class="opc">
                <div class="panel1">
                    <h1>Permiso para entradas<br> y salidas</h1>
                </div>
                <div class="ico">
                    <img src="../img/notes_102334.png" alt="Permiso" style="width:190px; height:190px">
                </div>
            </div>
        </a>

        <a href="vacaciones.php">
            <div class="opc">
                <div class="panel1">
                    <h1>Vacaciones</h1>
                </div>
                <div class="ico">
                    <img src="../img/cv_102350.png" alt="Aviso">
                </div>
            </div>
        </a>
    </div>

    <?php } ?>
<?php include('../lib/footer.php'); ?>

</body>

</html>
