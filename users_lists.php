<?php
	session_start();
	include_once('constants.inc.php');
	include_once('lib.inc.php');
	
	$id_user_p = clear_data($_POST['id_user_p'],'i');
	
	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki
	
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$sql_select = "SELECT u.login, l.list_id, l.list_name, l.list_created
								FROM user u
								INNER JOIN lists l ON u.id_user = l.user_id 
								WHERE l.user_id = '".$id_user_p."'
								ORDER BY l.list_created DESC";
	}
	$res = mysql_query($sql_select);
	$rows_n = mysql_num_rows($res);
	$answer = array();

	
	for ($i=0; $i < $rows_n; $i++){
		$row = mysql_fetch_assoc($res);
		array_push($answer, $row);
	}
	
	if($rows_n == 0){
		$sql_select = "SELECT login FROM user
						WHERE id_user = '".$id_user_p."'";
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
		<title><?= $answer[0]['login']; ?>::lists</title>

		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		<link href="style/table_lists.css" rel="stylesheet">

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
					<?php if($rows_n != 0){  ?>
						<div class="wybrane">Listy użytkownika: <i><b><?= $answer[0]['login']; ?></b></i></div>
						<table id="contener_list">
						<?php for($i=0; $i < $rows_n; $i++){   ?>
							<tr>
								<td class="text_list">Imię listy: </td>
								<td class="name_list"><?= $answer[$i]['list_name']; ?></td>
								<td class="text_list">Data stworzenia: </td>
								<td class="creata_list"><?= $answer[$i]['list_created']; ?></td>
								<td class="button_list">
									<form  action="shopping_list_for.php" method="post">
										<button class="button_li" name="id_list_f" value="<?= $answer[$i]['list_id']; ?>">Zobac</button>
									</form>
								</td>
							</tr>
						<?php	} ?>	
						</table>
					<?php	}else{ ?>
						<div class="wybrane">U użytkownika <i><b><?= $answer[0]['login']; ?></b></i> nie ma żadnej listę</div>
					<?php	} ?>
				</div>
				<div id="down"></div>
		</div>


<?php include('footer.inc'); ?>

