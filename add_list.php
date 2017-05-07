<?php
	include_once('constants.inc.php');
	include_once('lib.inc.php');
	session_start();
	
	if (!(($_COOKIE['islogged'] == "islogged") && (isset($_SESSION['nick']) && isset($_SESSION['ip'])))) {
		header("Location: index.php");
	}
	if (!$_SESSION['array_product']){
		header("Location: shopping_list.php");
	}

	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki

	
	
	if (($_SERVER['REQUEST_METHOD']=='POST') && ($_POST['zap'] == 'zap')){
		
		if($_SESSION['array_product']){
			$list_name = $_POST['poszukiwanie-i'];
			$id_user = $_SESSION['id_user'];
			$time = time();
			$mysqltime = date("Y-m-d H:i:s", $time);
			$session_list = serialize($_SESSION['array_product']);
			
				 $sql = "INSERT INTO lists (user_id, session_list, list_name, list_created)
					  VALUES
						 ('$id_user','$session_list','$list_name','$mysqltime')";
			mysql_query($sql);						
			unset($_SESSION['array_product']);
		}
	}
	mysql_close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Zapisać listę</title>
		
		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
        <script type="text/javascript" src="scripts/script.js"></script>
		<script type="text/javascript" src="scripts/register.js"></script>

	</head>

	<body>
	<div id="contener">
		<?php include('div_header_menu.inc'); ?>
		<?php include('div_right.inc.php'); ?>
		
		<div id="main">
				
				<div id="left">
					<?php if(!$list_name){ ?>
						<div class="wybrane">wprowadź imię listy</div>
						<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-poszukiwanie">
								<input type='hidden' name='zap' value="zap">
								
								<input type="text" name="poszukiwanie-i" id="poszukiwanie-i">
								<button id="sub-poszukiwanie" type="submit">Zapisać</button>	
						</form>
					<?php }else{ ?>
						<div class="wybrane">twoja lista została zapisana jako: <b><?= $list_name ?></b></div>
					<?php } ?>
	
				</div>
				<div id="down"></div>
		</div>

<?php include('footer.inc'); ?>