<?php
    require_once './config/Config.php';
    require_once './lib/ShowPDF.php';
    
    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: ./login.php");
    }

    $filePath = Config::$DIR_PDF_FILE;
    if(isset($_REQUEST['pdfName'])){
        $filePath .= $_REQUEST['pdfName'];
    }
   
    $pdf = new ShowPDF();

    if (!$pdf->show($filePath)) {
        $html = 'error: '.$pdf->errorMsg . '<br /><br />';
        //$html .= '<input type="button" class="btn btn-default" value="閉じる" onClick="if (/Chrome/i.test(navigator.userAgent)) { window.close(); } else { window.open(' . "'" . 'about:blank' . "'" . ',' . " '" . '_self'. "'" . ').close(); }"></a>';
        $html = mb_convert_encoding($html, 'sjis', 'utf-8');
        echo $html;
    }  
    
    exit();

?>