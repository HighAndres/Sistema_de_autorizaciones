<?php
define("USER", "root");
define("SERVER", "localhost");
define("BD", "permisos");
define("PASS", "");

	$conectar= mysqli_connect('localhost','pvaladez','rockyea1','permisos');

    if (!$conectar) {
        die("Ha fallado la conexión a la Base de Datos: " . mysqli_connect_error());
        exit();
    }

    mysqli_set_charset( $conectar, 'utf8');
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_ALL, 'es_MX');
?>