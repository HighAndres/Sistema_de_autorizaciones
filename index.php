<?php
include( 'lib/connect.php' );
session_start();
if (isset( $_SESSION['email'] ) && isset( $_SESSION['rol'] )) {
    switch( $_SESSION['rol'] ) {
        case 1:
            header( "Location:views/home.php" );
            break;
            
        case 2:
            header( "Location:views/home.php" );
            break;

        case 3:
            header( "Location:views/home.php" );
            break;
            
        case 4:
            header( "Location:views/solicitudes_dias.php" );
            break;
        
        default:
    }
}
// VALIDAR USUARIO
if ( isset( $_POST['email']) && isset( $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $resultado = $conectar->query( "SELECT * FROM usuarios WHERE (num_nomina='$email' OR email='$email') AND password='$password' LIMIT 1" );
    $arrayp=$resultado->fetch_assoc();
    $siesta = $resultado->num_rows;
    if ( $siesta == 1 ) {
    $_SESSION['email']=$email;
            $rol = $arrayp['rol_id'];
            $_SESSION['rol'] = $rol;
        switch( $_SESSION['rol'] ) {
                case 1:
                    header( "Location:views/home.php" );
                    break;

                case 2:
                    header( "Location:views/home.php" );
                    break;

                case 3:
                    header( "Location:views/home.php" );
                    break;

                case 4:
                    header( "Location:views/solicitudes_dias.php" );
                    break;

                default:
                }
        $_SESSION['success'] = 'toastr.success("¡Bienvenido!", "Acceso exitoso",{ "progressBar": true, "timeOut": "2000", "positionClass": "toast-top-center","hideMethod": "slideUp","extendedTimeOut": "700"})';
        exit();
    } else {
        $_SESSION['error'] = 'toastr.error("Error en el correo/número de nómina o contraseña", "Verifica tus datos",{  "closeButton": true,"progressBar": true,"positionClass": "toast-top-center", "timeOut": "7000", "hideMethod": "slideUp","extendedTimeOut": "900"})';
        header( "Location:index.php" );
        exit();
    }
}

//  REGISTRO DE USUARIO
if ( isset( $_REQUEST['e'] ) && !empty($_REQUEST['num_nomina'])) {

    $nombre=rtrim(mb_convert_case($_REQUEST['nombre'], MB_CASE_TITLE, "UTF-8"));
    $apellidos=mb_convert_case($_REQUEST['apellidos'], MB_CASE_TITLE, "UTF-8");
    $num_n = rtrim($_REQUEST['num_nomina']);
    $e = rtrim(strtolower($_REQUEST['e']));
    $pass = rtrim($_REQUEST['pass']);
    $rpass = rtrim($_REQUEST['rpass']);
    $checkemail = $conectar->query( "SELECT * FROM usuarios WHERE num_nomina='$num_n' OR email='$e'" );
    $checar = $checkemail->num_rows;
    if ( $pass == $rpass ) {
        if ( $checar == 1 ) {
            $_SESSION['error'] = 'toastr.warning("Ya existe el usuario designado, verifique sus datos", "Atención",{  "closeButton": true,"progressBar": true,"positionClass": "toast-top-center", "timeOut": "7000","hideMethod": "slideUp","extendedTimeOut": "700"})';
            header( "Location:index.php" );
            exit();
        } else {
            $conectar->query( "INSERT INTO usuarios VALUES(NULL,'$nombre', '$apellidos','$num_n','$e','$pass',default)" );
            $_SESSION['success'] = 'toastr.success("¡Ya puedes iniciar sesión!", "Usuario registrado",{ "progressBar": true, "positionClass": "toast-top-center","hideMethod": "slideUp","extendedTimeOut": "700"})';
            header( "Location:index.php" );
            exit();
            mysql_close( $link );
        }
    } else {
        $_SESSION['error'] = 'toastr.warning("Las contraseñas no coinciden, inténtalo de nuevo", "Atención",{  "closeButton": true,"progressBar": true,"positionClass": "toast-top-center", "timeOut": "7000","hideMethod": "slideUp","extendedTimeOut": "2000"})';
        header( "Location:index.php" );
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="icon" type="image/png" href="img/favicon.ico">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/toast/toastr.min.css">
    <script src="css/toast/toastr.min.js"></script>
</head>

<body>
    <?php include( 'jquery/alerts.php' );
?>
    <!-- partial:index.partial.html -->
    <div class="logmod">

        <span class="title">SISTEMA DE PERMISOS</span>

        <div class="logmod__wrapper">
            <div class="logmod__container">
                <ul class="logmod__tabs">
                    <li data-tabtar="lgm-2"><a href="#">Acceder</a></li>
                    <li data-tabtar="lgm-1"><a href="#">Registrarse</a></li>
                </ul>
                <div class="logmod__tab-wrapper">
                    <div class="logmod__tab lgm-1">
                        <div class="logmod__form">
                            <form class="simform" method="post">
                                <div class="sminputs">
                                    <div class="input string optional">
                                        <label class="string optional" for="user-pw">Nombre(s) *</label>
                                        <input class="string optional" name="nombre" maxlength="150" placeholder="Nombre" type="text" autocomplete="off" required />
                                    </div>
                                    <div class="input string optional">
                                        <label class="string optional" for="user-pw-repeat">Apellidos *</label>
                                        <input class="string optional" name="apellidos" maxlength="150" placeholder="Apellidos" type="text" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-name">Correo *</label>
                                        <input class="string optional" name="e" maxlength="255" id="user-email" placeholder="Correo" type="email" size="50" autocomplete="username" required />
                                    </div>
                                    <div class="input full" style="border-top: 1px solid #E5E5E5;">
                                        <label class="string optional" for="user-name">Número de nómina *</label>
                                        <input class="string optional" name="num_nomina" maxlength="40" placeholder="Nómina" type="number" size="50" autocomplete="off" pattern="^[0-9]" min="0" step="1" required onkeypress="return isNumberKey(this);">
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input string optional">
                                        <label class="string optional" for="user-pw">Contraseña *</label>
                                        <input class="string optional" name="pass" maxlength="255" id="user-pw" placeholder="Contraseña" type="password" size="50" autocomplete="current-password" required />
                                    </div>
                                    <div class="input string optional">
                                        <label class="string optional" for="user-pw-repeat">Repite la contraseña *</label>
                                        <input class="string optional" name="rpass" maxlength="255" id="user-pw-repeat" placeholder="Repite la contraseña" type="password" size="50" autocomplete="current-password" required />
                                    </div>
                                </div>
                                <div class="simform__actions">
                                    <span><img src="img/ggw.png" alt="GRUPO WALWORTH"></span>
                                    <input class="sumbit" name="commit" type="submit" value="Crear Cuenta" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="logmod__tab lgm-2">
                        <div class="logmod__heading">
                            <span class="logmod__heading-subtitle">Ingresa tu correo y contraseña para acceder al<strong> sistema de permisos</strong></span>
                        </div>
                        <div class="logmod__form">
                            <form method="post" class="simform">
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-name">Correo o número de nómina *</label>
                                        <input type="text" name="email" class="string optional" maxlength="255" id="user-emai" placeholder="Correo" size="50" autocomplete="username" required />
                                    </div>
                                </div>
                                <div class="sminputs">
                                    <div class="input full">
                                        <label class="string optional" for="user-pw">Contraseña *</label>
                                        <input type="password" name="password" class="string optional" maxlength="255" id="user-p" placeholder="Contraseña" size="50" autocomplete="current-password" required />
                                        <span class="hide-password">Mostrar</span>
                                    </div>
                                </div>
                                <div class="simform__actions">
                                    <span><img src="img/ggw.png" alt="GRUPO WALWORTH"></span>
                                    <input class="sumbit" name="commit" type="submit" value="Ingresar" />
                                </div>
                                <!--<div class="logmod__alter">
                                    <div class="logmod__alter-container">
                                        <a href="#" class="connect googleplus">
                                            <div class="connect__icon">
                                                <i class="fa fa-google"></i>
                                            </div>
                                            <div class="connect__context">
                                                <span>Accede con tu cuenta de <strong>Google</strong></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="jquery/script.js"></script>
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