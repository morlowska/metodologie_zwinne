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
	<h1><a href="index.php" title="cotaniej">Rejestracja i logowanie do serwisu cotaniej.pl</a></h1> </header>
 </header>
 <nav id="menu">
  <ul>
   <li><a href="form.php" title="Formualarz rejestracji">Formularz rejestracji</a></li>
   <li><a href="login.php" title="Formualarz logowania">Formularz logowania</a></li>
   <li><a href="database.php" title="Zrzut bazy danych">Kod bazy danych</a></li>
   <li><a href="userpanel.php" title="Plik dla zalogowanych użytkowników">Panel użytkownika</a></li>
   <li><a href="adres_powrotny" title="Powrót"><strong>Powrót</strong></a></li>>
  </ul>
 </nav>

 <section id="main">
    <?php
    if(isset($_SESSION['nick']) && isset($_SESSION['ip'])) {
        if(session_destroy()) {
            echo 'Wylogowano';
        }
    } else {
        echo 'Nie jesteś zalogowany. Przejdź do <a id="database" href="login.php">Formularza logowania</a>.';
    }
    ?>
 </section>
</body>
</html>

