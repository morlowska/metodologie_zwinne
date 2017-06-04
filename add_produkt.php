<?php
	include_once('constants.inc.php');
	include_once('lib.inc.php');
	
	session_start();
	
	if (!(($_COOKIE['islogged'] == "islogged") && (isset($_SESSION['nick']) && isset($_SESSION['ip'])))) {
		header("Location: index.php");
	}
	$id_user = $_SESSION['id_user'];

	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki
	
	$sql_select = "SELECT id, name FROM shops";
	$res = mysql_query($sql_select);
	$shop_id = clear_data($_POST['shop_id'],'i');
	if ($shop_id){
		$shop = mysql_result($res, $shop_id-1, 'name');
	}
	
	$sql_select_category = "SELECT category_id, category, category_title FROM categories";
	$res_category = mysql_query($sql_select_category);
	$category_id = clear_data($_POST['category_id'],'i');
	if ($category_id){
		$category = mysql_result($res_category, $category_id-1, 'category');
		$category_title = mysql_result($res_category, $category_id-1, 'category_title');
	}	

	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$product_name = clear_data($_POST['product_name'],'s');
		$price = clear_data($_POST['price']);
		$price = round($price*100)/100;
		$shop_id = clear_data($_POST['shop_id'],'i');
		$category_id = clear_data($_POST['category_id'],'i');
		$produkt_title = clear_data($_POST['produkt_title'],'s');
		$time = time();
		$mysqltime = date("Y-m-d H:i:s", $time);

		$rys = true;
		if ($product_name==false or is_numeric($product_name)==true or $price <= 0 or !$shop_id or !$category_id)
			$rys = false;
		
		$nadeslac = $_POST['nadeslac'];
		if($rys and !(isset($nadeslac))){
			if ($_FILES['userfile']['type'] == "image/png" or $_FILES['userfile']['type'] == "image/jpeg" or 
					$_FILES['userfile']['type'] == "image/gif" or $_FILES['userfile']['type'] == "image/pjpeg" or
					$_FILES['userfile']['type'] == "image/tiff"){
				$name_time_foto = $_FILES['userfile']['name'];

				if (!is_dir("image/tmp_image"))
					mkdir("image/tmp_image", 0777);
				if (!is_dir("image/product_image"))
					mkdir("image/product_image", 0777);

				move_uploaded_file($_FILES['userfile']['tmp_name'], 'image/tmp_image/'.$_FILES['userfile']['name']);	
			}
		}
		if (isset($nadeslac)){
			$sql = "INSERT INTO products (product_name, price, created_at, updated_at, shop_id, user_id, product_title, product_category)
				 VALUES
					('$product_name','$price','$mysqltime','$mysqltime', $shop_id, $id_user, '$produkt_title', '$category_id')";
			mysql_query($sql);		

			$id_producty = mysql_insert_id();	
			$name_time_foto = $_POST['name_time_foto'];
			$expansion = substr($name_time_foto, strrpos($name_time_foto, "."));
			$name_on_serwer = $id_producty.$expansion;
			rename("image/tmp_image/".$name_time_foto , "image/tmp_image/".$name_on_serwer );
			copy("image/tmp_image/".$name_on_serwer, "image/product_image/".$name_on_serwer);
			unlink("image/tmp_image/".$name_on_serwer);
		
			header("Location: ".$_SERVER['PHP_SELF']);
			exit;
		}
	}


	mysql_close();
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Dodać produkt</title>
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
					<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
							<label><p class="napis">nazwa produktu <input class="add_product" type="text" name="product_name" size="50" value="<?= $product_name ?>"></p></label>
							<label><p class="napis">cena produktu, zł <input class="add_product" type="text" name="price" size="50" value="<?= $price ?>"></p></label>		
							<p class="napis">sklep 
								<?php
									if (!$shop){
										echo "<select class='select_product' name='shop_id' size='1'>";
										echo "<option disabled selected>Wybierz sklep</option>";
										while ($row = mysql_fetch_assoc($res)){
											echo "<option value ='$row[id]'>{$row['name']}</option>";
										}
										echo "</select>";
									}else {
										echo "<input class='add_product' type='text'  size='50' value='".$shop."'>";
										echo "<input type='hidden' name='shop_id' value='".$shop_id."'>";
									}
								?>
							</p>	
							<p class="napis">kategoria
								<?php
									if (!$category){
										echo "<select class='select_product' name='category_id' size='1'>";
										echo "<option disabled selected>Wybierz kategorię</option>";
										while ($row_category = mysql_fetch_assoc($res_category)){
											echo "<option value ='$row_category[category_id]'>{$row_category['category_id']}. {$row_category['category']} ({$row_category['category_title']}) </option>";
										}
										echo "</select>";
									}else {
										echo "<input class='add_product' type='text'  size='50' value='".$category." (".$category_title.")'>";
										echo "<input type='hidden' name='category_id' value='".$category_id."'>";
									}
								?>
							</p>
							<label><p class="napis">opis produktu  <input class="add_product" type="text" name="produkt_title" size="50" value="<?= $produkt_title ?>"></p></label>

	

						<?php if ($rys == NULL){	?>						
							<label><p class="napis">dodaj foto <input class="add_product" name="userfile" type="file" /></p></label>	
							<button id="sub-add-product" type="submit">dalej</button>	
						<?php } else {	?>						
							<div class="add_product"><?= $_FILES['userfile']['name']; ?></div>
							<input type="hidden" name="name_time_foto" value='<?= $name_time_foto; ?>' >
							<input type="hidden" name="nadeslac" value="nadeslac" >
							<button id="sub-add-product-end" type="submit">dodaj</button>
						<?php } ?>
		
					</form>
				<?php if ($rys){ ?>
					<div class="napis">tak będzie wyglądać twój produkt po dodaniu</div>
					
					<table id="last-add">
						<tr>
						<?php if($_FILES['userfile']['name'] == NULL){ ?>
							<td class="photo" rowspan="4"><img src="image/default.jpg"></td>
						<?php }else{ ?>
							<td class="photo" rowspan="4"><img src="image/tmp_image/<?= $_FILES['userfile']['name']; ?>"></td>
						<?php } ?>					
							<td colspan="2" class="time"><?= date("Y-m-d G:i:s", $time) ?></td>
						</tr>
						
						<tr>
							<td class="product-name"><?= $product_name ?><div class="category_product"><?= $category ?></div></td>
							<td class="price"><?= $price ?></td>
						</tr>
						<tr class="tr_shop">
							<td colspan="2" class="shop"><?= $shop ?></td>
						</tr>
						<tr class="tr_produkt-title">	
							<td colspan="2" class="produkt-title">
								<?= $produkt_title ?>
							</td>
						</tr>
					</table>
				<?php } ?>
				</div>
				<div id="down"></div>
		</div>

<?php include('footer.inc'); ?>

