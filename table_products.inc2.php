<tr>
	<td class="shop"><?= $answer[$i]['name']; ?>
	    <?php
	        if(file_exists($answer[$i]['id'].'.txt'))
            {
              $buf = file_get_contents($answer[$i]['id'].'.txt');
            }
            else
            {
              $plik = fopen($answer[$i]['id'].'.txt', 'a');
              fclose($plik);
              $buf = file_get_contents($answer[$i]['id'].'.txt');
            }

	        if(!isset($_POST['ocena']) && isset($_SESSION['id_user']) && strstr($buf, $_SESSION['id_user']) == false)
            {
              echo '<div class="ocena_prod">
                <form id="GW1" action="?" method="post">
                  <input type="hidden" name="ocena" value="1">
                  <input type="hidden" name="id" value="'.$answer[$i]['id'].'">
                  <input type="image" src="image/1_gw_tlo.png" alt="1 gwiazdka" onmouseout="this.src='."'image/1_gw_tlo.png'".'" onmouseover="this.src='."'image/1_gwiazdka.png'".'">
                </form>
                <form id="GW2" action="?" method="post">
                  <input type="hidden" name="ocena" value="2">
                  <input type="hidden" name="id" value="'.$answer[$i]['id'].'">
                  <input type="image" src="image/2_gw_tlo.png" alt="2 gwiazdki" onmouseout="this.src='."'image/2_gw_tlo.png'".'" onmouseover="this.src='."'image/2_gwiazdki.png'".'">
                </form>
                <form id="GW3" action="?" method="post">
                  <input type="hidden" name="ocena" value="3">
                  <input type="hidden" name="id" value="'.$answer[$i]['id'].'">
                  <input type="image" src="image/3_gw_tlo.png" alt="3 gwiazdki" onmouseout="this.src='."'image/3_gw_tlo.png'".'" onmouseover="this.src='."'image/3_gwiazdki.png'".'">
                </form>
                <form id="GW4" action="?" method="post">
                  <input type="hidden" name="ocena" value="4">
                  <input type="hidden" name="id" value="'.$answer[$i]['id'].'">
                  <input type="image" src="image/4_gw_tlo.png" alt="4 gwiazdki" onmouseout="this.src='."'image/4_gw_tlo.png'".'" onmouseover="this.src='."'image/4_gwiazdki.png'".'">
                </form>
                <form id="GW5" action="?" method="post">
                  <input type="hidden" name="ocena" value="5">
                  <input type="hidden" name="id" value="'.$answer[$i]['id'].'">
                  <input type="image" src="image/5_gw_tlo.png" alt="5 gwiazdek" onmouseout="this.src='."'image/5_gw_tlo.png'".'" onmouseover="this.src='."'image/5_gwiazdek.png'".'">
                </form></div>';
            } elseif(isset($_SESSION['id_user']) && isset($_POST['ocena']) && $FLAG === null) {
                mysql_connect ("mysql.cba.pl","cotaniej","123Qwe");
                mysql_select_db ("cotaniej");
                mysql_query ("SET NAMES utf8");

                $FLAG = 'true';

              $id = $_POST['id'];

              switch($_POST['ocena'])
              {
                case 1:
                  $ocena = 1;
                  $plik = fopen($id.'.txt', 'a');
                  fwrite($plik, ';'.$_SESSION['id_user']);
                  fclose($plik);

                  $query = mysql_query ("SELECT `user_trust`, count(`id`) as amount FROM `products` JOIN `rate` ON `products`.id = `rate`.`id_product` WHERE `products`.id = ".$id);
                  $wynik = mysql_fetch_array($query);

                  $nowa_srednia = ($ocena + $wynik['user_trust'])/($wynik['amount'] + 1);

                  mysql_query("UPDATE `products` SET user_trust = ".$nowa_srednia." WHERE id = ".$id);

                  $data = date('Y-m-d H:i:s');
                  mysql_query("INSERT INTO `rate` (`id_product`, `id_user`, `date`, `rate`) VALUES(".$id.", ".$_SESSION['id_user'].", '".$data."',".$ocena.")");

                  mysql_close();
                  header('Location: ?');
                  break;
                case 2:
                  $ocena = 2;
                  $plik = fopen($id.'.txt', 'a');
                  fwrite($plik, ';'.$_SESSION['id_user']);
                  fclose($plik);

                  $query = mysql_query ("SELECT `user_trust`, count(`id`) as amount FROM `products` JOIN `rate` ON `products`.id = `rate`.`id_product` WHERE `products`.id = ".$id);
                  $wynik = mysql_fetch_array($query);

                  $nowa_srednia = ($ocena + $wynik['user_trust'])/($wynik['amount'] + 1);

                  mysql_query("UPDATE `products` SET user_trust = ".$nowa_srednia." WHERE id = ".$id);

                  $data = date('Y-m-d H:i:s');
                  mysql_query("INSERT INTO `rate` (`id_product`, `id_user`, `date`, `rate`) VALUES(".$id.", ".$_SESSION['id_user'].", '".$data."',".$ocena.")");

                  mysql_close();
                  header('Location: ?');
                  break;
                case 3:
                  $ocena = 3;
                  $plik = fopen($id.'.txt', 'a');
                  fwrite($plik, ';'.$_SESSION['id_user']);
                  fclose($plik);

                  $query = mysql_query ("SELECT `user_trust`, count(`id`) as amount FROM `products` JOIN `rate` ON `products`.id = `rate`.`id_product` WHERE `products`.id = ".$id);
                  $wynik = mysql_fetch_array($query);

                  $nowa_srednia = ($ocena + $wynik['user_trust'])/($wynik['amount'] + 1);

                  mysql_query("UPDATE `products` SET user_trust = ".$nowa_srednia." WHERE id = ".$id);

                  $data = date('Y-m-d H:i:s');
                  mysql_query("INSERT INTO `rate` (`id_product`, `id_user`, `date`, `rate`) VALUES(".$id.", ".$_SESSION['id_user'].", '".$data."',".$ocena.")");

                  mysql_close();
                  header('Location: ?');
                  break;
                case 4:
                  $ocena = 4;
                  $plik = fopen($id.'.txt', 'a');
                  fwrite($plik, ';'.$_SESSION['id_user']);
                  fclose($plik);

                  $query = mysql_query ("SELECT `user_trust`, count(`id`) as amount FROM `products` JOIN `rate` ON `products`.id = `rate`.`id_product` WHERE `products`.id = ".$id);
                  $wynik = mysql_fetch_array($query);

                  $nowa_srednia = ($ocena + $wynik['user_trust'])/($wynik['amount'] + 1);

                  mysql_query("UPDATE `products` SET user_trust = ".$nowa_srednia." WHERE id = ".$id);

                  $data = date('Y-m-d H:i:s');
                  mysql_query("INSERT INTO `rate` (`id_product`, `id_user`, `date`, `rate`) VALUES(".$id.", ".$_SESSION['id_user'].", '".$data."',".$ocena.")");

                  mysql_close();
                  header('Location: ?');
                  break;
                case 5:
                  $ocena = 5;
                  $plik = fopen($id.'.txt', 'a');
                  fwrite($plik, ';'.$_SESSION['id_user']);
                  fclose($plik);

                  $query = mysql_query ("SELECT `user_trust`, count(`id`) as amount FROM `products` JOIN `rate` ON `products`.id = `rate`.`id_product` WHERE `products`.id = ".$id);
                  $wynik = mysql_fetch_array($query);

                  $nowa_srednia = ($ocena + $wynik['user_trust'])/($wynik['amount'] + 1);

                  mysql_query("UPDATE `products` SET user_trust = ".$nowa_srednia." WHERE id = ".$id);

                  $data = date('Y-m-d H:i:s');
                  mysql_query("INSERT INTO `rate` (`id_product`, `id_user`, `date`, `rate`) VALUES(".$id.", ".$_SESSION['id_user'].", '".$data."',".$ocena.")");

                  mysql_close();
                  header('Location: ?');
                  break;
              }
            }
            else
            {
                mysql_connect ("mysql.cba.pl","cotaniej","123Qwe");
                mysql_select_db ("cotaniej");
                mysql_query ("SET NAMES utf8");

                $query = mysql_query ("SELECT `user_trust` FROM `products` WHERE id = ".$answer[$i]['id']);
                $wynik = mysql_fetch_array($query);

                echo '<div class="ocena_prod">ocena: '.$wynik[0].'</div>';

                mysql_close();
            }
	    ?>
	</td>
	<td class="button_dodaj">
		<?php if(!$_SESSION['array_product']){?>
			<button type="submit" form="form-poszukiwanie" class="button_d" name="button_d" value=<?= $answer[$i]['id']; ?> >dodaj do listy</button>
		<?php } ?>				
		<?php for($ses=0, $count_se=count($_SESSION['array_product']); $ses < $count_se; $ses++){ 
				if($answer[$i]['id'] == $_SESSION['array_product'][$ses]){ ?>
					<button class="button_jest" >dodano do listy</button>
		<?php 	BREAK;
				}if($answer[$i]['id'] != $_SESSION['array_product'][$ses] && $ses == $count_se-1){?>
					<button type="submit" form="form-poszukiwanie" class="button_d" name="button_d" value=<?= $answer[$i]['id']; ?> >dodaj do listy</button>
		<?php }	} ?>
	</td>
</tr>