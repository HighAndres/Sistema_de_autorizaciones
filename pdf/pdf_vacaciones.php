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

if (isset($_GET["refv"])){
    $id=$_GET['refv'];
    $datos=$conectar->query("SELECT * FROM vacaciones WHERE MD5(concat('".$key."',id_vcns))='".$id."'");
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
    $pdf->SetFont('Arial','B',15);  
    $pdf->SetFillColor(255,255,255);
    $pdf->SetXY(10,18);
    $pdf->Cell(8);
    $pdf->MultiCell(125,14,utf8_decode('AVISO DE VACACIONES'), 0,'L',true);
    $pdf->SetXY(196,14);
    $pdf->SetFont('Arial','B',10);  
    $pdf->Cell(17,13,utf8_decode('FECHA:'),1, 0,'R',true);
    $pdf->Cell(15,13,utf8_decode(strftime("%d", strtotime($areq['fecha_registro']))), 1, 0,'C');
    $pdf->Cell(15,13,utf8_decode(strftime("%b", strtotime($areq['fecha_registro']))),1, 0,'C',true);
    $pdf->Cell(15,13,utf8_decode(strftime("%Y", strtotime($areq['fecha_registro']))),1, 0,'C',true);
    $pdf->SetXY(213,23);
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

    $pdf->SetFont('Arial','',12);  
    $pdf->Cell(8);
    $pdf->Cell(18,9,utf8_decode('Puesto: '), 1, 0,'L',true);
    $pdf->Cell(82,9,utf8_decode($areq['puesto']), 1, 0,'C');
    $pdf->Cell(60,9,utf8_decode('Fecha de ingreso: '), 1, 0,'C',true);
    $pdf->Cell(22,9,utf8_decode(date('d', strtotime($areq['fecha_ingreso']))), 1, 0,'C');
    $pdf->Cell(22,9,utf8_decode(date('m', strtotime($areq['fecha_ingreso']))), 1, 0,'C');
    $pdf->Cell(36,9,utf8_decode(date('Y', strtotime($areq['fecha_ingreso']))), 1, 1,'C');


    $pdf->SetFont('Arial','B',8);  
    $pdf->Ln(8);
    $pdf->Cell(8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',14); 
    $pdf->Cell(60,9,utf8_decode('DÍAS DE VACACIONES'), 0, 1,'L',false);
    $pdf->SetFont('Arial','',12); 
    $pdf->Cell(8);
    /*$pdf->Cell(100,10,utf8_decode('De acuerdo a la fecha de ingreso le corresponden: '), 1, 0,'l',true);
    $pdf->Cell(30,10,utf8_decode($areq['num_dias_vcns']), 1, 0,'C');    
    $pdf->Cell(50,10,utf8_decode('días por el periodo: '), 1, 0,'C',true);
    $pdf->Cell(30,10,utf8_decode($areq['periodo1']), 1, 0,'C');
    $pdf->Cell(30,10,utf8_decode($areq['periodo2']), 1, 1,'C');
    $pdf->Cell(8);*/

    $pdf->Cell(30,10,utf8_decode('Disfrutará de:'), 1, 0,'L',true);
    $pdf->Cell(30,10,utf8_decode($areq['num_dias_a_difrutar']), 1, 0,'C');    
    $pdf->Cell(23,10,utf8_decode('días del: '), 1, 0,'C',true);
    $pdf->Cell(20,10,utf8_decode(date('d', strtotime($areq['dias_a_difrutar_del']))), 1, 0,'C');
    $pdf->Cell(20,10,utf8_decode(date('m', strtotime($areq['dias_a_difrutar_del']))), 1, 0,'C');
    $pdf->Cell(25,10,utf8_decode(date('Y', strtotime($areq['dias_a_difrutar_del']))), 1, 0,'C');
    $pdf->Cell(27,10,utf8_decode('al día: '), 1, 0,'C',true);
    $pdf->Cell(20,10,utf8_decode(date('d', strtotime($areq['dias_a_difrutar_al']))), 1, 0,'C');
    $pdf->Cell(20,10,utf8_decode(date('m', strtotime($areq['dias_a_difrutar_al']))), 1, 0,'C');
    $pdf->Cell(25,10,utf8_decode(date('Y', strtotime($areq['dias_a_difrutar_al']))), 1, 1,'C');
    $pdf->Cell(8);
    $pdf->Ln(2);

    $pdf->Cell(8);
    $pdf->Cell(83,10,utf8_decode('Debiendo regresar a sus labores el día: '), 1, 0,'L',true);
    $pdf->Cell(20,10,utf8_decode(date('d', strtotime($areq['regreso']))), 1, 0,'C');
    $pdf->Cell(20,10,utf8_decode(date('m', strtotime($areq['regreso']))), 1, 0,'C');
    $pdf->Cell(25,10,utf8_decode(date('Y', strtotime($areq['regreso']))), 1, 1,'C');
    $pdf->Cell(8);
    $pdf->Ln(2);

    $pdf->Cell(8);
    $pdf->Cell(18,10,utf8_decode('Restan: '), 1, 0,'L',true);
    $pdf->Cell(30,10,utf8_decode($areq['dias_restantes']), 1, 0,'C');    
    $pdf->Cell(35,10,utf8_decode('días'), 1, 1,'C',true);
    /*$pdf->Cell(30,10,utf8_decode($areq['periodo_restantes1']), 1, 0,'C');
    $pdf->Cell(30,10,utf8_decode($areq['periodo_restantes2']), 1, 1,'C');*/

    $pdf->Ln(8);
    $pdf->Cell(8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',14); 
    $pdf->Cell(60,9,utf8_decode('PRIMA DE VACACIONES'), 0, 1,'L',false);
    $pdf->Cell(8);
    $pdf->SetFont('Arial','',12); 
    $pdf->Cell(46,10,utf8_decode('Prima correspondiente: '), 1, 0,'L',true);
    $pdf->Cell(40,10,utf8_decode($areq['prima_vacacional']), 1, 0,'C');
    $pdf->SetFont('Arial','',11); 
    $pdf->Cell(154,10,utf8_decode('% pagar por concepto de vacaciones según antigüedad sobre los días a disfrutar'), 1, 0,'L');  

    $pdf->Ln(6);
    $pdf->SetXY(90,155);
    $pdf->SetFont('Arial','B',12);   
    $pdf->Cell(100,8,utf8_decode('Estatus de solicitud'), 1, 1,'C',true);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFont('Arial','',13);  
    $pdf->Cell(80);
    $pdf->Cell(100,20,utf8_decode($areq['estatus']), 1, 0,'C');

    $pdf->SetFont('Arial','B',6);  
    $pdf->SetXY(170,60);
    $pdf->Cell(22,4,utf8_decode('día'),0, 0,'C');
    $pdf->Cell(22,4,utf8_decode('mes'),0, 0,'C');
    $pdf->Cell(22,4,utf8_decode('año'),0, 1,'C');
    $pdf->SetXY(101,87);
    $pdf->SetFont('Arial','B',6);  
    $pdf->Cell(20,4,utf8_decode('día'),0, 0,'L');
    $pdf->Cell(20,4,utf8_decode('mes'),0, 0,'L');
    $pdf->Cell(25,4,utf8_decode('año'),0, 1,'L');
    $pdf->SetXY(101,99);
    $pdf->SetFont('Arial','B',6);  
    $pdf->Cell(20,4,utf8_decode('día'),0, 0,'L');
    $pdf->Cell(20,4,utf8_decode('mes'),0, 0,'L');
    $pdf->Cell(25,4,utf8_decode('año'),0, 1,'L');
    $pdf->SetXY(193,87);
    $pdf->Cell(20,4,utf8_decode('día'),0, 0,'L');
    $pdf->Cell(20,4,utf8_decode('mes'),0, 0,'L');
    $pdf->Cell(25,4,utf8_decode('año'),0, 1,'L');

    //SALIDA PDF
    $pdf ->Output('vacaciones_'.$id.'.pdf','I');
    $pdf ->Output();
?>
