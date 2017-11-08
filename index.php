<?php
    require_once './config/Config.php';

	session_start();
	if (!isset($_SESSION["user_id"])) {
		header("Location: ./login.php");
	}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Index</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<link rel="stylesheet" href="css/style.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="page-header">
			<div class="clearfix">
                <div class="header-left">
                    <p>TOPページ</p>
                </div>
                <div class="header-right">
                    <a href="./logout.php"><i class="glyphicon glyphicon-log-out" style="font-size:13px;">ログアウト</i></a>
                </div>
            </div>
		</div>
        <div class="wrapper-list">
		    <div class="list-contents"> 
		        <?php 
		            for ($i=1; $i<6; $i++){
		            	$fileName = 't' . $i . '.pdf';
                        $filePath = Config::$DIR_PDF_FILE . $fileName;

                        if (file_exists($filePath)){
                        	echo '<p><a href=outputPDF.php?pdfName='. $fileName . ' target="_blank">' . $fileName . '</a></p>';
                        } else {
                            echo '<p>' . $fileName . '</p>';
                        }
		            }
		        ?>              
            </div>
        </div>
	</div>
</body>
</html>