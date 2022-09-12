<?php 
    session_start();
    session_destroy();
    unset($_SESSION['email']);
    unset($_SESSION['rol']);
    session_start();
    $_SESSION['log_out']='toastr.info("¡Hasta luego!", "Sesión cerrada",{ "closeButton": true,"progressBar": true,"positionClass": "toast-top-center","timeOut": "6000","hideMethod": "slideUp","extendedTimeOut": "800"})';
    header("Location: ../index.php");
    exit();
    session_destroy();
?>