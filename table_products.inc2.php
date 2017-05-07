<tr>
	<td class="shop"><?= $answer[$i]['name']; ?></td>
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