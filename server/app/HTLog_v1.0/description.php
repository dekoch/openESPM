<?php

	$appTitle = 'HTLog';

	$appDescriptionSimple = 'Humidity and Temperature Data Logger';

	$appDescriptionFull = 	'Recording of climatic values for air humidity and temperature.<br>
							You can see all records as line chart on a daily basis.<br>
							The data can also be exported as .csv for further calculations.<br>
							<br>
							Request URL: "request.php?id={your device id}&ctemp={celsius temperature}&ftemp={fahrenheit temperature}&humidity={humidity}"<br>
							json response: {"interval":"60"}<br>
							(interval parameter: e.g. 60 seconds sleep time)';

	$appDeveloper = 'dekoch';

	$appUrl = '';

	$appChangelog = 'v1.0.2<br>+chart width optimization<br>
					<br>
					v1.0.1<br>+show min. avg. max.<br>+check user and device input values<br>
					<br>
					v1.0<br>first version';

?>
