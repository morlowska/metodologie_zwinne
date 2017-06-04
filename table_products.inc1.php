<tr>
	<?php 
		$name_serch = NULL;
		$name_files = scandir("image/product_image/");
		$number_of_array_name_file = count($name_files);
		for ($p=2; $p < $number_of_array_name_file; $p++){
			
			$name_of_serwer_file = substr( $name_files[$p], 0, strrpos($name_files[$p], "."));	
			if ($name_of_serwer_file == $answer[$i]['id']){
				$name_serch = $name_files[$p];
				break;
			}
		}
		if (is_file("image/product_image/".$name_serch)){ 
	?>
		<td class="photo" rowspan="4"><img src="image/product_image/<?= $name_serch;?>"></td>
	<?php }else{ ?>
		<td class="photo" rowspan="4"><img src="image/default.jpg"></td>
	<?php } ?>
	
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