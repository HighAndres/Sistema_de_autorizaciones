<!DOCTYPE html>
<html lang="es">

<head><meta charset="gb18030">
    
</head>

<body>
    <?php
    $email=$conectar->query("SELECT * FROM usuarios WHERE email='".$_SESSION['email']."' OR num_nomina='".$_SESSION['email']."' AND rol_id='".$_SESSION['rol']."'");
    $auser=$email->fetch_assoc();

        echo "<header>";
        echo "<div class='top_head'><img class='img_head' src='../img/icon.png' alt=''><label class='upper_head'> PERMISOS</label></div>";
        echo "<nav>";
        echo '<div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                <span><b>BIENVENIDO:</b></span><br>
                &nbsp;&nbsp;
                <b>'.$auser['nombre']." ". $auser['apellidos'].'</b>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout">Cerrar sesión</a>
              </div>
            </div>';
        echo "</nav>";
        echo "</header>";
?>

    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:17px">ATENCIÓN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <label for="" style="font-size:18px; font-family: 'Poppins', serif;"><strong>¿Deseas salir del sistema de permisos?</strong></label><br>
                    </center>
                </div>
                <div class="modal-footer">
                    <a href="../lib/log_out.php" type="submit" name="editar" class="btn btn-success" style="margin-right:auto">Aceptar</a>
                    <button type="button" class="btn btn-danger clear" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
