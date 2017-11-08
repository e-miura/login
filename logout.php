<!--
  ログアウト画面
-->
<?php 
	session_start();
	//SESSIONの値を初期化
	$_SESSION = array();

	//SESSIONクッキーも削除　http://d.hatena.ne.jp/Kappuccino/20080726/1217049706
	if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
	}
	//サーバー側のSESSIONを破棄
	session_destroy();

    header ('Location: ./login.php?url=logout');
    exit();

?>
