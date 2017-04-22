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
  <form action="register.php" method="POST" id="register-form">
      <fieldset>
	    <dl>
		 <dt><label for="nick">Nick:</label></dt>
		  <dd><input type="text" name="login" id="nick" placeholder="jankowalski"></dd>
		 <dt><label for="password">Hasło:</label></dt>
		  <dd><input type="password" name="password" id="password" placeholer="password"></dd>
		 <dt><label for="email">E-mail:</label></dt>
		  <dd><input type="text" name="email" placeholder="jankowalski@domena.pl" id="email"></dd>
		 <dt><input type="submit" name="check" value="Rejestruj"></dt>
		</dl>
	  </fieldset>
    </form>
 </section>
</body>
</html>

