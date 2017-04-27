<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="pl">
 <head>
  <meta charset="UTF-8">
  <title>cotaniej</title>
  <link rel="stylesheet" href="style.css">
 </head>
<body>
 <header>
  <h1><a href="index.php" title="cotaniej">Rejestracja i logowanie do serwisu cotaniej.pl</a></h1>
 </header>
 <nav id="menu">
  <ul>
   <li><a href="form.php" title="Formualarz rejestracji">Formularz rejestracji</a></li>
   <li><a href="login.php" title="Formualarz logowania">Formularz logowania</a></li>
   <li><a href="database.php" title="Zrzut bazy danych">Kod bazy danych</a></li>
   <li><a href="userpanel.php" title="Plik dla zalogowanych użytkowników">Panel użytkownika</a></li>
   <li><a href="adres_powrotny" title="Powrót"><strong>Powrót</strong></a></li>
  </ul>
 </nav>

 <section id="main">
  <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
        $login    = $_POST['login'];
	    $password = $_POST['password'];
		 
	    if (empty($login) || empty($password)) {
		  return '<p>Wypełnij wszystkie dane.</p>';
		} else {
		    if (file_exists('config.php')) {
                include_once('config.php');
		    } else {
		        return 'config.php file not found.';
		    }
		
            $mysqli = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['database']);
	
		    if ($mysqli -> connect_error) {
                return '<p>Problem z połączeniem się z bazą danych:' . $mysqli->connect_error . '[' . $mysqli->connect_errno . ']</p>';
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
                    header('Location: userpanel.php');
                } else {
                    echo '<p>Brak podanego użytkownika w bazie.</p>';
                }
            }
		}
    }
  ?>
 </section>
</body>
</html>
<?php
ob_end_flush();
?>
