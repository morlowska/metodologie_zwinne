<?php
	session_start();
	include_once('constants.inc.php');
	include_once('lib.inc.php');

	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki

	if ($_SERVER['REQUEST_METHOD']=='POST' && $_POST['button_d']){
		$id_usun_produktu = $_POST['button_d'];
		for($i=0, $count_se = count($_SESSION['array_product']); $i < $count_se; $i++){
			if($_SESSION['array_product'][$i] == $id_usun_produktu){
				if ($i == $count_se-1){
					unset($_SESSION['array_product'][$i]);
					BREAK;
				}
				for($j=$i; $j < $count_se-1; $j++){
					$_SESSION['array_product'][$j] = $_SESSION['array_product'][$j+1];
				}
				unset($_SESSION['array_product'][$count_se-1]);
				BREAK;				
			}
		}
	}

	$rows_n = count($_SESSION['array_product']);
	$answer = array();
				
	for ($i=0;$i<$rows_n; $i++){
		$sql_select = "SELECT p.product_name, p.price, p.created_at, p.product_title, p.user_id, p.id, s.name
						FROM products p
						INNER JOIN shops s ON p.shop_id = s.id 
						WHERE p.id=".$_SESSION['array_product'][$i];
		$res = mysql_query($sql_select);
		$row = mysql_fetch_assoc($res);	
		array_push($answer, $row);
	}

	mysql_close();	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Lista zakupów</title>

		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		<link href="style/table_products.css" rel="stylesheet">

        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
        <script type="text/javascript" src="scripts/script.js"></script>
		<script type="text/javascript" src="scripts/register.js"></script>
		
		<style type="text/css">#here{top: 0;left: 460px;width: 140px;}</style>
		
	</head>

	<body>
	<div id="contener">
		<?php include('div_header_menu.inc'); ?>
		<?php include('div_right.inc.php'); ?>
					  
		<div id="main">
				
				<div id="left">
					<?php if ($_SESSION['array_product']){ ?>
						<div class="wybrane">Wybrane produkty</div>
						<table id="last-add">	
							<?php for($i=0; $i < $rows_n; $i++){   ?>
								<?php include('table_products.inc1.php'); ?>
								<?php include('table_products.inc4.php'); ?>
								<?php include('table_products.inc3.php'); ?>
							<?php	} ?>
						</table>					
					<?php }else{ ?>
						<div class="wybrane">Na dany moment nic nie wybrano</div>
					<?php } ?>
					
				</div>
				<div id="down"></div>
		</div>


<?php include('footer.inc'); ?>

