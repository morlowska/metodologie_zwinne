<link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon"/>

<?php
	session_start();
	include_once('constants.inc.php');
	include_once('lib.inc.php');
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

	if ($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['wyszyk'] == 'szykaj') && (!$_POST['button_d'])){
		$poszukiwanie = clear_data($_POST['poszukiwanie-i'],'s'); 

		if (!(empty($poszukiwanie))){
			$sql_select = "SELECT p.product_name, p.price, p.created_at, p.product_title, p.user_id, p.id, s.name
							FROM products p
							INNER JOIN shops s ON p.shop_id = s.id 
							WHERE p.product_name LIKE '%".$poszukiwanie."%'
							ORDER BY p.created_at DESC";
		}
	}else{
		$sql_select = "SELECT p.product_name, p.price, p.created_at, p.product_title, p.user_id, p.id, s.name
						FROM products p
						INNER JOIN shops s ON p.shop_id = s.id 
						ORDER BY p.created_at DESC
						LIMIT 10";
	}
	$res = mysql_query($sql_select);
	$rows_n = mysql_num_rows($res);

	$answer = array();

	if (($_COOKIE['islogged'] == "islogged") && isset($_SESSION['nick']) && isset($_SESSION['ip'])) {
		$id_user = $_SESSION['id_user'];
		$res1 = mysql_query($sql_select);	

		for ($i=0; $i < $rows_n; $i++){
			$row = mysql_fetch_assoc($res1);
			if ($row['user_id'] == $id_user)
				array_push($answer, $row);
		}
	}
	for ($i=0; $i < $rows_n; $i++){
		$row = mysql_fetch_assoc($res);
		if ($row['user_id'] != $id_user)
			array_push($answer, $row);
	}
	mysql_close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Główna</title>
		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		<link href="style/table_products.css" rel="stylesheet">

        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
        <script type="text/javascript" src="scripts/script.js"></script>
		<script type="text/javascript" src="scripts/register.js"></script>

		<style type="text/css">#here{top: 0;left: 15px;width: 100px;}</style>
	</head>
	<body>
	<div id="contener">
		<?php include('div_header_menu.inc'); ?>
		<?php include('div_right.inc.php'); ?>
		<div id="main">				
				<div id="left">				
					<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-poszukiwanie">
							<input type='hidden' name='wyszyk' value="szykaj">
							<input type="text" name="poszukiwanie-i" id="poszukiwanie-i">
							<button id="sub-poszukiwanie" type="submit">szukaj</button>	
					</form>
					<?php if($rows_n != 0){  ?>
						<div id="last-add-p">ostatnio dodane</div>		
					<?php include('table_products.inc.php'); ?>														
					<?php	}elseif(empty($poszukiwanie)){	
						echo "<div id='div_wysz_wpr'>nic nie wprowadzono dla wyszukiwarki!</div>";
					}else{
						echo "<div id='div_wysz_zn'>nic nie znaleziono dla: <b>".$poszukiwanie."</b></div>";
					}?>
				</div>
				<div id="down"></div>
		</div>
<?php include('footer.inc'); ?>



