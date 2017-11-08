<?php
	require_once './config/Config.php';
	require_once './lib/MySQLComponent.php';

	$loginMsg = '';

	session_start();

	if(isset($_POST["login"])){

		$uid = $_POST["user"]["id"];
		$pass = $_POST["user"]["pass"];

		if (chkUserIdPass($uid, $pass) == true) {
			//セッションに書き込む
	    	$_SESSION["user_id"] = $uid;
	    	//新規にセッションID発行（セッションジャック対策）
	    	session_regenerate_id(true);
	    	//管理者画面へ遷移
      		header("Location: ./index.php");

		}else{
			$loginMsg = 'IDまたはパスワードが違います。';
		}
	}

	function chkUserIdPass($id, $pass) {	

		//DBへ確認
		try {

			$db = new MySQLComponent(Config::$DB_HOST, Config::$DB_NAME, Config::$DB_USER, Config::$DB_PASSWORD);
			$db->connect();

			$sql = '';
			$sql .= 'SELECT login_id, password FROM ' . Config::$DB_TBL_USER . ' ';
			$sql .= 'WHERE login_id = ? AND password = ? AND del_flg = ?';

			$bind_values = [
				['value' => $id],
				['value' => $pass],
				['value' => '0']
			];

			$rows = $db->select($sql, $bind_values);

		}catch (PDOException $e){
			$loginMsg = 'DB接続に失敗しました。';
		}

		if (count($rows) > 0) {
			return true;
		}else{
			return false;
		}
	}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ログイン</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<div class="login-wrapper">
			<form action="./login.php" method="post" class="form-login">
				<div class="form-login-header">
					<h2>ログイン画面</h2>
				</div>
				<?php if (isset($_SERVER['HTTP_REFERER']) && isset($_REQUEST["url"])): ?>
                    <?php if ($_REQUEST["url"] == "logout"): ?>
    			        <div class="alert alert-info" role="alert">
					        <?php echo "ログアウトしました。"; ?>
				        </div>
				    <?php endif ?>    
				<?php endif ?>
				<?php if ($loginMsg != ''): ?>
					<div class="alert alert-danger" role="alert">
						<?php echo $loginMsg; ?>
					</div>
				<?php endif ?>

				<div class="form-group">
					<input type="text" class="form-control" placeholder="User ID" name="user[id]" size="20" >
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Password" name="user[pass]" size="20" >
				</div>
				<button type="submit" class="btn btn-lg btn-success btn-block" name="login" value="login">ログイン</button>
				<input type="hidden" name="url" value="" >
			</form>
		</div>
	</div>
</body>
</html>

