<?php  
    //PDF CODE START
    define('FPDF_FONTPATH', '.');
    require('fpdf.php');
    $pdf = new FPDF();
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "qrlib/qrlib.php";    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))mkdir($PNG_TEMP_DIR);

    $PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'Downloads'.DIRECTORY_SEPARATOR;
    if (!file_exists($PDF_DIR))mkdir($PDF_DIR);
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'H';//array('L','M','Q','H')
    $matrixPointSize = 10;// 1 to 10
    $matrixPointSize = min(max((int)$matrixPointSize, 1), 10);
    //PDF CODE END
      
    $noofQRs = 2;
    for($i=1;$i<=$noofQRs;$i++){
            $qrcodeValue = rand(10000,99999);
            $imageName = $qrcodeValue;
            $filename = $PNG_TEMP_DIR.$imageName.'.png';
            QRcode::png($imageName, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            $pdf->AddPage();//1 page will create
            $pdf->AddFont('Helvetica-Bold','','helveticab.php');
            $img1 = $PNG_WEB_DIR.basename($filename);
            $pdf->Image($img1,5,10,200);
            $pdf->Ln(220);   
            $pdf->SetFont('Helvetica-Bold','',28);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(0,0,$imageName,0,0,'C');
    }
    $targetFile = 'Downloads/qrcodes.pdf';
    $contentToStore = $pdf->Output($targetFile ,'F'); 
    // echo '<a target="_blank" href="'.$targetFile.'" download> <button> Download PDF </button></a>';
      
?>