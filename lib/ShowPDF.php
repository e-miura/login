<?php
/*--------------------------------------------
 *	PDF表示クラス
 *-------------------------------------------*/
class ShowPDF {

	Public $errorMsg = '';

	//コンストラクタ
	function __construct() {
		
	}

	function outputFile($filePath)
  	{
	    header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: public");
	    header("Content-Description: File Transfer");
	    header("Content-Type: application/pdf");
	    header('Content-Disposition: inline;filename="' . basename($filePath) .'"');
	    header("Content-Transfer-Encoding: binary");
	    header("Content-Length: ".filesize($filePath));
	    ob_clean();
	    flush();
	    readfile($filePath);
  	}

  	function show($filePath) {
  		try {
  			//ファイル存在チェック
	  		if (file_exists($filePath)) {
	  			//PDF表示
				$this->outputFile($filePath);
			}else{
				throw new RuntimeException('ファイルが存在しません。');
			}	
		}catch(RuntimeException $e) {
			$this->errorMsg = $e->getMessage();
			return false;
		}
		return true;	
  	}
}