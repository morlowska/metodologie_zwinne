<?php
	include_once('constants.inc.php');
	include_once('lib.inc.php');
	session_start();

	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki
	
	if (!(($_COOKIE['islogged'] == "islogged") && (isset($_SESSION['nick']) && isset($_SESSION['ip'])))) {
		header("Location: index.php");
		exit;
	}	
	if ($_SERVER['REQUEST_METHOD']=='POST' or $_GET['end']== true){  
		$id_product_edit = clear_data($_POST['id_product_edit'],'i');
		if($_GET['end']== true){$id_product_edit = clear_data($_GET['id_product_edit'],'i');}
		
		$sql_select_product = "SELECT p.product_name, p.price, p.created_at, p.product_title, p.user_id, p.id, s.name, c.category
						FROM products p
						INNER JOIN shops s ON p.shop_id = s.id 
						INNER JOIN categories c ON p.product_category = c.category_id
						WHERE p.id =".$id_product_edit;
		
		$sql_select_history = "SELECT h.old_price, h.new_price, h.updated_at, u.login
						FROM history_edit h
						INNER JOIN user u ON h.user_id_updated = u.id_user
						WHERE h.product_id =".$id_product_edit."
						ORDER BY h.updated_at DESC";
	}
	$res_product = mysql_query($sql_select_product);
	$res_history = mysql_query($sql_select_history);
	
	$rows_n = mysql_num_rows($res_product);
	$rows_history = mysql_num_rows($res_history);
	
	$row = mysql_fetch_assoc($res_product);
	$answer = array();
	array_push($answer, $row);

	$answer_history = array();
	for($i=0; $i<$rows_history;$i++){
		$row_history = mysql_fetch_assoc($res_history);
		array_push($answer_history, $row_history);
	}
		
	$end = $_GET['end'];
	echo($end);
	
	if($_POST['redaguj']== 'redaguj' && !$end){
		$new_price = clear_data($_POST['price'],'i');
		$new_price = round($new_price*100)/100;
		$old_price = $answer[0]['price'];
		
		if($new_price > 0 && $new_price!=$old_price){
			$answer[0]['price'] = $new_price;
			$product_id = $answer[0]['id'];
			$time = time();
			$mysqltime_update = date("Y-m-d H:i:s", $time);
			$id_user = $_SESSION['id_user'];
			$end = true;
			
			$sql_insert = "INSERT INTO history_edit (product_id, user_id_updated, old_price, new_price, updated_at)
				 VALUES
					('$product_id','$id_user','$old_price','$new_price','$mysqltime_update')";
			mysql_query($sql_insert);
			
			$sql_update = "UPDATE products 
							SET price='$new_price', 
								updated_at='$mysqltime_update' 
							WHERE id = $id_product_edit";
			mysql_query($sql_update);

			header ('location: edit_product.php?end='.$end.'&id_product_edit='.$id_product_edit);
			exit;
		} 
	}		
	mysql_close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Edytować produkt</title>
		
		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		<link href="style/table_products.css" rel="stylesheet">
		<link href="style/add_product.css" rel="stylesheet">

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
					<div>
						<div class="wybrane">Wybrany produkt dla redagowanie</div>	
						
						<table id="last-add">	
							<?php for($i=0; $i < $rows_n; $i++){   ?>
								<tr>
									<td class="photo" rowspan="4"><img src="image/default.jpg"></td>
									<td class="time" colspan="2">
										<?= $answer[$i]['created_at']; ?>
										<?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $answer[$i]['user_id']) 
											echo '<span class="twoj_produkt">Twój produkt</span>';
										?>
									</td>
								</tr>
								<tr>
									<td class="product-name"><?= $answer[$i]['product_name']; ?><div class="category_product"><?= $answer[$i]['category']; ?></div></td>
									<td class="price">
									
									<?php if($end){ 
												echo($answer[$i]['price']);
										  }else{ ?>	
										<form  action="edit_product.php" method="post" id="redaguj_prduct">
											<input class="edit_price" type="text" name="price" size="14" value="<?= $answer[$i]['price']; ?>">
											<input type='hidden' name='id_product_edit' value="<?= $id_product_edit; ?>">
										</form>
										<div style="font-size:18px; margin-top:3px; margin-right:40px;"><i>np: 2.69</i></div>
									<?php } ?>		
									</td>
								</tr>
								<tr>
									<td class="shop"><?= $answer[$i]['name']; ?></td>
									<td class="button_dodaj"></td>
								</tr>
								<tr>	
									<td class="produkt-title">
										<?= $answer[$i]['product_title']; ?>
									</td>
									<td class="button_skomentuj">
										<?php if(!$end){ ?>
											<button form="redaguj_prduct" class="button_d button_edit" type="submit" name="redaguj" value="redaguj">Redaguj</button>
										<?php }?>
									</td>
								</tr>
							<?php	} ?>
						</table>
						
						<div class="wybrane">Historia redagowania produktu:</div>
						<?php
							for ($j=0,$i=$rows_history; $i>0;$i--,$j++){
								echo("<div class='list_history'>");
								echo($i.". Produkt był redagowany przez użytkownika <b><i>".
									$answer_history[$j]['login']."</i></b>, od <b><i>".
									$answer_history[$j]['updated_at']."</i></b>. Cena była zmieniona z <b><i>".
									$answer_history[$j]['old_price']."</i></b> na <b><i>".
									$answer_history[$j]['new_price']."</i></b>");
								echo("</div>");
							}
						?>
					</div>	
				</div>
				<div id="down"></div>
		</div>
<?php include('footer.inc'); ?>