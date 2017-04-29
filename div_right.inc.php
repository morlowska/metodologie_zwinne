<?php
	
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['forma'] == 1)){
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
		$login    = $_POST['login-i'];
		$password = $_POST['haslo-i'];
		 
		if (empty($login) || empty($password)) {
		  echo '<div class="err">Wypełnij wszystkie dane.</div>';
		} else {
			if (file_exists('constants.inc.php')) {
				include_once('constants.inc.php');
			} else {
				echo '<div class="err">constants.inc.php file not found.</div>';
			}
		
			$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
	
			if ($mysqli -> connect_error) {
				echo '<div class="err">Problem z połączeniem się z bazą danych:' . $mysqli->connect_error . '[' . $mysqli->connect_errno . ']</div>';
			} else {
				$login     = trim(strip_tags($mysqli -> real_escape_string($login)));
				$password  = hash('sha256', trim(strip_tags($mysqli -> real_escape_string($password))));

				$result = $mysqli -> query("SELECT login, ip, id_user FROM `user` WHERE login = '$login' and password = '$password'");
				if ($result -> num_rows == 1) {
					$row = $result -> fetch_row();
					$_SESSION['nick'] = $row[0];
					$_SESSION['ip']   = $row[1];
					$_SESSION['id_user'] = $row[2];
					setcookie('islogged', 'islogged', time() + 3600); // 1h
					header('Location:'.$_SERVER['PHP_SELF']);
				} else {
					echo '<div class="err">Brak podanego użytkownika w bazie.</div>';
				}
			}
		}
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['forma'] == 2)){
		
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
	   	 
	    $login    = $_POST['rej-login-i'];
	    $password = $_POST['rej-haslo-i'];
	    $email    = $_POST['rej-email-i'];
	 
	    if(empty($login) || empty($password) || empty($email)) {
		    header("Location: index.php?err=1");
		}
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		    header("Location: index.php?err=2");
		}
		else {
            if (file_exists('constants.inc.php')) {
                include_once('constants.inc.php');
            } else {
                header("Location: index.php?err=4");
            }

            $mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

            if($mysqli -> connect_error) {
                header("Location: index.php?err=3");
            } else {
                $login     = trim(strip_tags($mysqli -> real_escape_string($login)));
                $password  = hash('sha256', trim(strip_tags($mysqli -> real_escape_string($password))));
                $email     = trim(strip_tags($mysqli -> real_escape_string($email)));
                $ip        = $_SERVER['REMOTE_ADDR'];

                $stmt = $mysqli -> prepare("INSERT INTO `user`(`id_user`, `login`,`password`,`email`,`added`,`ip`) VALUES('', ? , ? , ? , now(), ?)");
                $stmt -> bind_param('ssss', $login, $password, $email, $ip);
                $stmt -> execute();

                if($stmt -> affected_rows == 1) {
                    echo '<div class="err">Zostałeś pomyślnie zarejestrowany</div>';
					
					$result = $mysqli -> query("SELECT login, ip, id_user FROM `user` WHERE login = '$login' and password = '$password'");
					if ($result -> num_rows == 1) {
						$row = $result -> fetch_row();
						$_SESSION['nick'] = $row[0];
						$_SESSION['ip']   = $row[1];
						$_SESSION['id_user'] = $row[2];
						setcookie('islogged', 'islogged', time() + 3600); // 1h
						header("Location: index.php?scs=1");
					}
					
                } else {
                    header("Location: index.php?err=4");
                }
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['forma'] == 3)){
	setcookie('islogged', 'unlogged', time() + 3600);
	session_destroy();
	header('Location:'.$_SERVER['PHP_SELF']);
}


?>



<div id='right'>


	<?php if (($_COOKIE['islogged'] == "islogged") && (isset($_SESSION['nick']) && isset($_SESSION['ip']))){ ?>
		<p id="logowanie-p">Jesteś </br>zalogowany </br>jako:</br> <?php echo($_SESSION['nick']); ?></p></br>
		
		<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<input type='hidden' name='forma' value=3>
			
			<button id="sub-wylog" type="submit">Wyloguj się</button>
		</form>

		<button id="sub-produkt"><a id="a-produkt" href="add_produkt.php">Dodaj produkt</a></button>
		


		
	<?php }else{  ?>
		<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-log">
			<input type='hidden' name='forma' value=1>
			
			<p id="logowanie-p">logowanie</p></br>
			<p id="login-p">login</br><input type="text" name="login-i" id="login-i"></p>
			<p id="haslo-p">hasło</br><input type="password" name="haslo-i" id="haslo-i"></p>
			<button id="sub-log" type="submit">zaloguj się</button>
			<a id="rejestracja" href="#">rejestracja</a>
		</form>

		<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-rej">
			<input type='hidden' name='forma' value=2>
		
			<p id="rej-p">rejestracja użytkownika</p></br>
			<p id="rej-login-p">login *</br><input type="text" name="rej-login-i" id="rej-login-i"></p>
			<p id="rej-email-p">Email *</br><input type="text" name="rej-email-i" id="rej-email-i"></p>
			<p id="rej-haslo-p">hasło *</br><input type="password" name="rej-haslo-i" id="rej-haslo-i"></p>
			<p id="rej-haslo-rep-p">powtórz hasło *</br><input type="password" name="rej-haslo-rep-i" id="rej-haslo-rep-i"></p>
			<button id="sub-rej" type="submit">zaloż konto</button>
		</form>

	<?php } ?>	

</div>






