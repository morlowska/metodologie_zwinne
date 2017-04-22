<?php
ob_start();
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
	<h1><a href="index.php" title="cotaniej">Rejestracja i logowanie do serwisu cotaniej.pl</a></h1> </header>
  </ul>
 </nav>

 <section id="main">
 <?php
    if (empty($_COOKIE['islogged'])) {
        header('Refresh: 5; url=login.php');
        return '<p>Czas sesji wygasł. Proszę zalogować się ponownie.</p><p> Za chwilę nastąpi przepierowanie</p>';
   }

   if (isset($_SESSION['nick']) && isset($_SESSION['ip'])) {
       echo '<p>Treść dla zalogowanych</p>';
       echo '<a id="database" href="logout.php">Wyloguj</a>';
       echo "<br/><br/><a href='add_produkt.php'>Dodać produkt</a><br/>";
   } else {
       echo '<p>Nie jesteś zalogowany. Przejdź do <a id="database" href="login.php">Formularza logowania</a>.</p>';
   }
 ?>
 </section>
</body>
</html>
<?php
ob_end_flush();
?>