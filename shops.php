<?php
	session_start();
	include_once('constants.inc.php');
	include_once('lib.inc.php');

	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki

	if ($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['wyszyk'] == 1)){
		$poszukiwanie = clear_data($_POST['poszukiwanie-i-sk'],'s'); 
		
		if (!(empty($poszukiwanie))){
			$sql_select = "SELECT p.id, p.shop_id, s.name
							 FROM products p
							 INNER JOIN shops s ON p.shop_id = s.id
							 WHERE s.name LIKE '%".$poszukiwanie."%'
							 ORDER BY s.name";		
		}
	}else{
		$sql_select = "SELECT p.id, p.shop_id, s.name
							 FROM products p
							 INNER JOIN shops s ON p.shop_id = s.id
							 ORDER BY s.name";
	}
	$res = mysql_query($sql_select);
	$rows_n = mysql_num_rows($res);

	
	$answer = array();
	for ($i=0; $i < $rows_n; $i++){
		
		$row = mysql_fetch_assoc($res);
		
		$count = count($answer);
		if ($count == 0){
			$answer[$count]['name'] = $row['name'];
			$answer[$count]['count_products'] = 1;
			continue;
		}
		for ($j=0; $j<$count; $j++){
			if($row['name'] == $answer[$j]['name']){
				$answer[$j]['count_products'] += 1;
			}
			if($j == $count-1 & $row['name'] != $answer[$j]['name']){
				$answer[$count]['name'] = $row['name'];
				$answer[$count]['count_products'] = 1;
			}
		}
	}
	
	mysql_close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sklepy</title>

		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		<link href="style/table_products.css" rel="stylesheet">
		<link href="style/table_shops.css" rel="stylesheet">

        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
        <script type="text/javascript" src="scripts/script.js"></script>
		<script type="text/javascript" src="scripts/register.js"></script>
		
		<style type="text/css">#here{top: 0;left: 160px;width: 85px;}</style>
		
	</head>

	<body>
	<div id="contener">
		<?php include('div_header_menu.inc'); ?>
		<?php include('div_right.inc.php'); ?>
					  
		<div id="main">
				
				<div id="left">
					
					<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-poszukiwanie">
						<input type='hidden' name='wyszyk' value=1>
						
						<input type="text" name="poszukiwanie-i-sk" id="poszukiwanie-i">
						<button id="sub-poszukiwanie" type="submit">szukaj sklepu</button>	
					</form>


					<?php if($rows_n != 0){  ?>
					
						<div id="list-shop-p">lista sklepów</div>
						
						<table id="shops">
							<?php for ($i=0; $i < count($answer); $i++){ ?>
								<tr>
									<td class="photo" rowspan="2">
										<img src="image/default.jpg">
									</td>
									<td class="shop"><?= $answer[$i]['name']; ?></td>
									<td class="button" rowspan="2">
										<form  action="list_for.php" method="post">
											<input type='hidden' name='name' value=<?= $answer[$i]['name']; ?> >
											<button class="sub-pok" type="submit">zobacz</button>
										</form>
									</td>
								</tr>
								<tr>
									<td class="products"><?= $answer[$i]['count_products'] ?> produkty</td>
								</tr>
							<?php } ?>
						</table>
					
					<?php	}elseif(empty($poszukiwanie)){	
						echo "<div id='div_wysz_wpr'>nic nie wprowadzono dla wyszukiwarki!</div>";
					}else{
						echo "<div id='div_wysz_zn'>nic nie znaleziono dla: <b>".$poszukiwanie."</b></div>";
					}?>

				</div>
				<div id="down"></div>
		</div>


<?php include('footer.inc'); ?>

