<?php
    require_once('./fpdf/fpdf.php');
    include('../lib/connect.php');

session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['rol'])) {
	header("Location:../index.php");
}

//FECHA Y HORA ACTUAL 
date_default_timezone_set('America/Mexico_City');
//CIFRADO
$key = '5973C777%B7673309895AD%FC2BD1962C1062B9?3890FC277A04499¿54D18FC13677';

if (isset($_GET["refd"])){
    $id=$_GET['refd'];
    $datos=$conectar->query("SELECT * FROM entrada_salida WHERE MD5(concat('".$key."',id_es))='".$id."'");
    $areq=$datos->fetch_assoc();
}


class PDF extends FPDF
{
    
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Times','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
}
}

   //Creación del objeto de la clase heredada
    $pdf = new PDF('L','mm','Letter');
    $pdf->SetFont('Arial','I',8);

    $pdf->AliasNbPages();
    $pdf ->AddPage();

    //HEADER
    $pdf->Cell(8);
    $pdf->Image('../img/ggw.png',16,8,50);
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln(7);
    $pdf->SetFont('Arial','B',13);  
    $pdf->SetFillColor(255,255,255);
    $pdf->SetXY(10,22);
    $pdf->Cell(8);
    $pdf->MultiCell(125,8,utf8_decode('AUTORIZACIÓN DE INASISTENCIA, ENTRADA O SALIDA DE LAS INSTALACIONES FUERA DE HORARIO'), 0,'L',true);
    $pdf->SetXY(161,23);
    $pdf->SetFont('Arial','B',8);  
    $pdf->Cell(52,14,utf8_decode('FECHA DE ENTREGA A VIGILANCIA:'),1, 0,'L',true);
    $pdf->Cell(15,14,strftime("%d"),1, 0,'C',true);
    $pdf->Cell(15,14,strftime("%b"),1, 0,'C',true);
    $pdf->Cell(15,14,strftime("%Y"),1, 1,'C',true);
    $pdf->SetXY(213,33);
    $pdf->SetFont('Arial','B',8);  
    $pdf->Cell(15,4,utf8_decode('día'),0, 0,'C');
    $pdf->Cell(15,4,utf8_decode('mes'),0, 0,'C');
    $pdf->Cell(15,4,utf8_decode('año'),0, 1,'C');
    $pdf->Ln(10);

    //BODY
    $pdf->Cell(8);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(243,243,243);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',14);   
    $pdf->Cell(100,9,utf8_decode('Nombre del solicitante: '), 1, 0,'C',true);
    $pdf->Cell(70,9,utf8_decode('Departamento: '), 1, 0,'C',true);
    $pdf->Cell(70,9,utf8_decode('Número de nómina: '), 1, 1,'C',true);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFont('Arial','',13);  
    $pdf->Cell(8);
    $pdf->Cell(100,9,utf8_decode($areq['nombre_solicitante']), 1, 0,'C');
    $pdf->Cell(70,9,utf8_decode($areq['departamento']), 1, 0,'C');
    $pdf->Cell(70,9,utf8_decode($areq['num_nomina']), 1, 1,'C');
    $pdf->Ln(8);

    $pdf->Cell(8);
    if($areq['fecha_salida']>0 && $areq['hora_salida']>0) {
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',13);   
    $pdf->Cell(75,10,utf8_decode('Se autoriza la SALIDA a las: '), 1, 0,'R',true);
    $pdf->Cell(43,10,utf8_decode(date('H:i', strtotime($areq['hora_salida']))), 1, 0,'C');   
    $pdf->SetFont('Arial','',13);   
    $pdf->Cell(22,10,utf8_decode('del día: '), 1, 0,'C',true);
    $pdf->Cell(13,10,utf8_decode(date('d', strtotime($areq['fecha_salida']))), 1, 0,'C');
    $pdf->Cell(13,10,utf8_decode(date('m', strtotime($areq['fecha_salida']))), 1, 0,'C');
    $pdf->Cell(17,10,utf8_decode(date('Y', strtotime($areq['fecha_salida']))), 1, 1,'C');
        }else{
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',13);   
            $pdf->Cell(75,10,utf8_decode('Se autoriza la SALIDA a las: '), 1, 0,'R',true);
            $pdf->Cell(43,10,'', 1, 0,'C');   
            $pdf->SetFont('Arial','',13);   
            $pdf->Cell(22,10,utf8_decode('del día: '), 1, 0,'C',true);
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(17,10,'', 1, 1,'C');
        }

    $pdf->Cell(8);
    if($areq['fecha_entrada']>0 && $areq['hora_entrada']>0) {
        $pdf->Cell(75,10,utf8_decode('Se autoriza la ENTRADA a las: '), 1, 0,'R',true);
        $pdf->Cell(43,10,utf8_decode(date('H:i', strtotime($areq['hora_entrada']))), 1, 0,'C');
        $pdf->Cell(22,10,utf8_decode('del día: '), 1, 0,'C',true);
        $pdf->Cell(13,10,utf8_decode(date('d', strtotime($areq['fecha_entrada']))), 1, 0,'C');
        $pdf->Cell(13,10,utf8_decode(date('m', strtotime($areq['fecha_entrada']))), 1, 0,'C');
        $pdf->Cell(17,10,utf8_decode(date('Y', strtotime($areq['fecha_entrada']))), 1, 1,'C');
        }else{
            $pdf->Cell(75,10,utf8_decode('Se autoriza la ENTRADA a las: '), 1, 0,'R',true);
            $pdf->Cell(43,10,'', 1, 0,'C');
            $pdf->Cell(22,10,utf8_decode('del día: '), 1, 0,'C',true);
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(17,10,'', 1, 1,'C'); 
            } 

    $pdf->Cell(8);
    if($areq['inasistencia_del']>0 && $areq['inasistencia_al']>0) {
    $pdf->Cell(75,10,utf8_decode('Se autoriza INASISTENCIA del: '), 1, 0,'R',true);
    $pdf->Cell(13,10,utf8_decode(date('d', strtotime($areq['inasistencia_del']))), 1, 0,'C');
    $pdf->Cell(13,10,utf8_decode(date('m', strtotime($areq['inasistencia_del']))), 1, 0,'C');
    $pdf->Cell(17,10,utf8_decode(date('Y', strtotime($areq['inasistencia_del']))), 1, 0,'C');
    $pdf->Cell(22,10,utf8_decode('al día: '), 1, 0,'C',true);
    $pdf->Cell(13,10,utf8_decode(date('d', strtotime($areq['inasistencia_al']))), 1, 0,'C');
    $pdf->Cell(13,10,utf8_decode(date('m', strtotime($areq['inasistencia_al']))), 1, 0,'C');
    $pdf->Cell(17,10,utf8_decode(date('Y', strtotime($areq['inasistencia_al']))), 1, 0,'C');
        }else{
            $pdf->Cell(75,10,utf8_decode('Se autoriza INASISTENCIA del: '), 1, 0,'R',true);
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(17,10,'', 1, 0,'C');
            $pdf->Cell(22,10,utf8_decode('al día: '), 1, 0,'C',true);
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(13,10,'', 1, 0,'C');
            $pdf->Cell(17,10,'', 1, 0,'C');
        }
    $pdf->SetFont('Arial','B',13);   
    $pdf->SetXY(213,73);
    $pdf->Cell(45,10,utf8_decode('Goce de sueldo:'), 1, 1,'C',true); 
    $pdf->SetXY(213,83);
    $pdf->SetFont('Arial','',13);   
    $pdf->Cell(45,20,utf8_decode($areq['goce_sueldo']), 1, 1,'C');
    $pdf->Ln(8);

    $pdf->Cell(8);
    $pdf->SetFont('Arial','B',13);   
    $pdf->Cell(240,9,utf8_decode('Observaciones:'), 1, 1,'C',true);
    $pdf->Cell(8);
    $pdf->SetFont('Arial','',11);   

    $pdf->MultiCell(240,9,utf8_decode($areq['observaciones']), 1, 'L');

    $pdf->Ln(10);
    $pdf->SetXY(90,145);
    $pdf->SetFont('Arial','B',12);   
    $pdf->Cell(100,8,utf8_decode('Estatus de solicitud'), 1, 1,'C',true);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFont('Arial','',13);  
    $pdf->Cell(80);
    $pdf->Cell(100,20,utf8_decode($areq['estatus']), 1, 0,'C');

    $pdf->SetFont('Arial','B',7);  
    $pdf->SetXY(129,75);
    $pdf->Cell(5,8,utf8_decode('hrs.'),0, 0,'C');
    $pdf->SetXY(129,85);
    $pdf->Cell(5,8,utf8_decode('hrs.'),0, 0,'C');
    $pdf->SetXY(93,100);
    $pdf->SetFont('Arial','B',6);  
    $pdf->Cell(13,4,utf8_decode('día'),0, 0,'C');
    $pdf->Cell(13,4,utf8_decode('mes'),0, 0,'C');
    $pdf->Cell(17,4,utf8_decode('año'),0, 1,'C');
    $pdf->SetXY(158,80);
    $pdf->SetFont('Arial','B',6);  
    $pdf->Cell(13,4,utf8_decode('día'),0, 0,'C');
    $pdf->Cell(13,4,utf8_decode('mes'),0, 0,'C');
    $pdf->Cell(17,4,utf8_decode('año'),0, 1,'C');
    $pdf->SetXY(65,187);
    $pdf->SetXY(158,90);
    $pdf->Cell(13,4,utf8_decode('día'),0, 0,'C');
    $pdf->Cell(13,4,utf8_decode('mes'),0, 0,'C');
    $pdf->Cell(17,4,utf8_decode('año'),0, 1,'C');
    $pdf->SetXY(158,100);
    $pdf->Cell(13,4,utf8_decode('día'),0, 0,'C');
    $pdf->Cell(13,4,utf8_decode('mes'),0, 0,'C');
    $pdf->Cell(17,4,utf8_decode('año'),0, 1,'C');
    $pdf->SetXY(65,187);
    $pdf->SetXY(65,187);

    //SALIDA PDF
    $pdf ->Output('permiso_'.$id.'.pdf','I');
    $pdf ->Output();
?>