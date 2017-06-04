<link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon"/>


<?php
	session_start();
	include_once('constants.inc.php');
	include_once('lib.inc.php');

	mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_NAME) or die(mysql_error());
	mysql_query("SET CHARSET utf8"); // polskie znaki
	mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); // polskie znaki
	
	if ($_SERVER['REQUEST_METHOD']=='POST' && ($_POST['wyszyk'] == 1)){
		$poszukiwanie = clear_data($_POST['poszukiwanie-i'],'s'); 
		
		if (!(empty($poszukiwanie))){
			$sql_select = "SELECT id_user, login, email, added
						FROM user
						WHERE login LIKE '%".$poszukiwanie."%'
						OR email LIKE '%".$poszukiwanie."%'
						ORDER BY added DESC";
		}
	}else{
		$sql_select = "SELECT id_user, login, email, added
						FROM user
						ORDER BY added DESC
						LIMIT 10";
	}
	$res = mysql_query($sql_select);

	$rows_n = mysql_num_rows($res);
	$answer = array();

	for ($i=0; $i < $rows_n; $i++){
		$row = mysql_fetch_assoc($res);
		array_push($answer, $row);
	}

	mysql_close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Użytkownicy</title>

		<link href="style/common.css" rel="stylesheet">
		<link href="style/form.css" rel="stylesheet">
		<link href="style/form_rej.css" rel="stylesheet">
		<link href="style/table_user.css" rel="stylesheet">

        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
        <script type="text/javascript" src="scripts/script.js"></script>
		<script type="text/javascript" src="scripts/register.js"></script>
		
		<style type="text/css">#here{top: 0;left: 285px;width: 130px;}</style>
		
	</head>

	<body>
	<div id="contener">
		<?php include('div_header_menu.inc'); ?>
		<?php include('div_right.inc.php'); ?>
					  
		<div id="main">
				
				<div id="left">
				
					<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-poszukiwanie">
						<input type='hidden' name='wyszyk' value=1>
						
						<input type="text" name="poszukiwanie-i" id="poszukiwanie-i">
						<button id="sub-poszukiwanie" type="submit">szukaj użytkownika</button>	
					</form>
					
					<?php if($rows_n != 0){  ?>
						<div id="list-shop-p">lista użytkowników</div>
		
						<table id="users">
						<?php for($i=0; $i < $rows_n; $i++){   ?>
							<tr class="tr_top">
								<td class="photo" rowspan="3">
									<img src="image/default.jpg">
								</td>
								<td class="tytul_log">Login użytkownika:</td>
								<td class="login"><?= $answer[$i]['login'] ?></td>
								<td class="button">
									<form  action="users_lists.php" method="post">
										<input type='hidden' name='id_user_p' value=<?= $answer[$i]['id_user']; ?> >
										<button class="sub-pok" type="submit">listy</button>	
									</form>
								</td>
							</tr>
							<tr>
								<td class="tytul_log">Email użytkownika:</td>
								<td class="email"><?= $answer[$i]['email'] ?></td>
								<td class="button">
									<form  action="list_for.php" method="post">
										<input type='hidden' name='id_user_p' value=<?= $answer[$i]['id_user']; ?> >
										<button class="sub-pok" type="submit">produkty</button>
									</form>
								</td>
							</tr>
							<tr class="tr_down">
								<td class="tytul_log">Zarejestrowany od:</td>
								<td class="zarejestrowany"><?= $answer[$i]['added'] ?></td>
								<td class="ocena">Ocena użytkownika: ???</td>
							</tr>
						<?php	} ?>
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

