<?php
	session_start();
	include_once('constants.inc.php');
	include_once('lib.inc.php');

	$id_list_f = $_POST['id_list_f'];

	if (!$id_list_f)
	    $id_list_f = $_GET['id_list_f'];
	
	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki
	
	if ($_SERVER['REQUEST_METHOD']=='POST' && $_POST['button_d']){
		$id_pobr_produktu = $_POST['button_d'];
		if (!$_SESSION['array_product']){
			$_SESSION['array_product'] = array();
		}
		array_push($_SESSION['array_product'], $id_pobr_produktu);
	}
	
	if ($_SERVER['REQUEST_METHOD']=='POST' || $id_list_f){
		$sql_select = "SELECT u.login, l.list_name, l.list_created, l.session_list
						FROM user u
						INNER JOIN lists l ON u.id_user = l.user_id 
						WHERE l.list_id = '".$id_list_f."'";
	
		$res = mysql_query($sql_select);
		$row = mysql_fetch_assoc($res);
		
		$login = $row['login']; 
		$list_name = $row['list_name']; 
		$list_created = $row['list_created']; 
		$session_list = unserialize($row['session_list']);
		

		$rows_n = count($session_list);
		$answer = array();
		for ($i=0;$i<$rows_n; $i++){
			$sql_select = "SELECT p.product_name, p.price, p.created_at, p.product_title, p.user_id, p.id, s.name, c.category
							FROM products p
							INNER JOIN shops s ON p.shop_id = s.id 
							INNER JOIN categories c ON p.product_category = c.category_id
							WHERE p.id=".$session_list[$i];
			$res = mysql_query($sql_select);
			$row = mysql_fetch_assoc($res);	
			array_push($answer, $row);
		}
	}
	
	mysql_close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?= $login; ?>::<?= $list_name; ?></title>

		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		<link href="style/table_products.css" rel="stylesheet">
		
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

					<?php if ($session_list || $id_list_f){ ?>
						<div class="wybrane">Lista użytkownika: <i><b><?= $login; ?></b></i></div>
						<div class="info_wybrane">Imię listy: <i><b><?= $list_name; ?></b></i></div>
						<div class="info_wybrane">Data stworzenia: <i><b><?= $list_created; ?></b></i></div>
						<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-poszukiwanie">
							<input type='hidden' name='id_list_f' value="<?= $id_list_f; ?>">
						</form>
						<table id="last-add">	
							<?php for($i=0; $i < $rows_n; $i++){   ?>
								<?php include('table_products.inc1.php'); ?>
								<?php include('table_products.inc2.php'); ?>
								<?php include('table_products.inc3.php'); ?>
							<?php	} ?>
						</table>					
					<?php }else{ ?>
						<div class="wybrane">W danej liście nie ma produktów</div>
					<?php } ?>
				</div>
				<div id="down"></div>
		</div>


<?php include('footer.inc'); ?>

