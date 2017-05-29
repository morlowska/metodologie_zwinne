<tr>
	<td class="photo" rowspan="4"><img src="image/default.jpg"></td>
	<td class="time" colspan="2">
		<?= $answer[$i]['created_at']; ?>
		<?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $answer[$i]['user_id']) 
			echo '<span class="twoj_produkt">Twój produkt</span>';
		?>
	</td>
</tr>
<tr>
	<td class="product-name"><?= $answer[$i]['product_name']; ?><div class="category_product"><?= $answer[$i]['category']; ?></div></td>
	<td class="price"><?= $answer[$i]['price']; ?></td>
</tr>