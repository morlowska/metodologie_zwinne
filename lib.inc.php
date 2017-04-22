<?php
function clear_data($data, $type='i'){
	switch($type){
		case 'i': return $data*1;break;
		case 's': return stripslashes(trim(htmlspecialchars($data,ENT_QUOTES)));break;
	}
}
?>