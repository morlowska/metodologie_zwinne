<tr>
	<td class="shop"><?= $answer[$i]['name']; ?></td>
	<td class="button_dodaj">
		<form  action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<button type="submit" class="button_d" name="button_d" value=<?= $answer[$i]['id']; ?> >Usuń z listy</button>
		</form>	
	</td>
</tr>