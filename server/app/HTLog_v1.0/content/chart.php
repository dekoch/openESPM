<?php

	if(file_exists($file))
	{
		include_once './functions/csv.php';

		$array = read_csv($file);

		$chartTime = '';
		$chartTemp = '';
		$lastTemp = 0;
		$chartHumidity = '';
		$lastHumidity = 0;

		foreach ($array as $set)
		{
			if($set[0] != 0)
			{
				$chartTime = $chartTime.'"'.date('H:i:s', $set[0]).'",';

				if($appini['tempunit'] == 'F')
				{
					$chartTemp = $chartTemp.$set[2].',';
					$lastTemp = $set[2];
				}
				else
				{
					$chartTemp = $chartTemp.$set[1].',';
					$lastTemp = $set[1];
				}

				$chartHumidity = $chartHumidity.$set[3].',';
				$lastHumidity = $set[3];
			}
		}

		// remove last ;
		$chartTime = substr($chartTime, 0, strlen($chartTime) - 1);
		$chartTemp = substr($chartTemp, 0, strlen($chartTemp) - 1);
		$chartHumidity = substr($chartHumidity, 0, strlen($chartHumidity) - 1);
	}

?>


<SCRIPT src='./app/HTLog_v1.0/js/chart/ChartNew.js'></script>

<SCRIPT>

	function setColor(area,data,config,i,j,animPct,value)
	{
	  if(value > 35)return("rgba(220,0,0,"+animPct);
	  else return("rgba(0,220,0,"+animPct);
	  
	}

	var charJSPersonnalDefaultOptions = { decimalSeparator : "," , thousandSeparator : ".", roundNumber : "none", graphTitleFontSize: 2 };

	defCanvasWidth=document.documentElement.clientWidth / 100 * 80;
	defCanvasHeight=300;


	var temperatureData = {
		labels : [<?php echo $chartTime; ?>],
		datasets : [
			{
				title : "Temperature",
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "green",
				pointstrokeColor : "yellow",
				data : [<?php echo $chartTemp; ?>]
			}
		]
	}        

	var humidityData = {
		labels : [<?php echo $chartTime; ?>],
		datasets : [
			{
				title : "Humidity",
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "green",
				pointstrokeColor : "yellow",
				data : [<?php echo $chartHumidity; ?>]		
			}
		]
	}               

	var startWithDataset = 1;
	var startWithData = 1;

	var temperatureOpt = {
		animationStartWithDataset : startWithDataset,
		animationStartWithData : startWithData,
		animationSteps : 30,
		canvasBorders : false,
		canvasBordersWidth : 3,
		canvasBordersColor : "black",
		graphTitle : "<?php echo $lastTemp.' '.$appini['tempunit']; ?>",
		legend : true,
		inGraphDataShow : false,
		annotateDisplay : true,
		graphTitleFontSize: 18
	}

	var humidityOpt = {
		animationStartWithDataset : startWithDataset,
		animationStartWithData : startWithData,
		animationSteps : 30,
		canvasBorders : false,
		canvasBordersWidth : 3,
		canvasBordersColor : "black",
		graphTitle : "<?php echo $lastHumidity; ?> %RH",
		legend : true,
		inGraphDataShow : false,
		annotateDisplay : true,
		graphTitleFontSize: 18
	}
</SCRIPT>

<script>

	document.write("<canvas id=\"canvas_Line1\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");
	document.write("<canvas id=\"canvas_Line2\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");
	window.onload = function() {


	var myLine = new Chart(document.getElementById("canvas_Line1").getContext("2d")).Line(temperatureData,temperatureOpt);

	var myLine = new Chart(document.getElementById("canvas_Line2").getContext("2d")).Line(humidityData,humidityOpt);
}
</script>
