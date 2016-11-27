<?php

	$newswitch = 'off';

	if($appini['switch'] == 'on')
	{  
		$newswitch = 'on';
	}

	// json
	echo '{"switch":"'.$newswitch.'"}';
	
?>
