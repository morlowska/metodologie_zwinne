<tr>	
	<td class="produkt-title">
		<?= $answer[$i]['product_title']; ?>
	</td>
	<td class="button_skomentuj">
		<?php if(($_COOKIE['islogged'] == "islogged") && isset($_SESSION['nick']) && isset($_SESSION['ip'])){ ?>
			<form  action="edit_product.php" method="post">
				<input type="hidden" name="id_product_edit" value=<?= $answer[$i]['id']; ?> >
				<button class="button_d button_edit" type="submit">Redaguj</button>
			</form>
		<?php }?>
	<button class="button_d" name="button_sk" value=<?= $answer[$i]['id']; ?> >Skomentuj</button>
	</td>
</tr>
