
<?php

	// Devices per App
		$usedApps = array();

		foreach($devices as $dev)
		{
			$usedApps[] = $dev->app;
		}

		$apidevices = list_api_devices();

		foreach($apidevices as $dev)
		{
			$usedApps[] = $dev->app;
		}

		// count devices per app
		$apps = list_applications();
		$statsApp = array();

		for ($i = 0; $i < count($usedApps); $i++)
		{
			for ($n = 0; $n < count($apps); $n++)
			{
				if($usedApps[$i] == $apps[$n])
				{
					$statsApp[$usedApps[$i]] += 1;
				}
			}
		}

		// create datasets
		$dataDevPerApp = '';

		for ($i = 0; $i < count($apps); $i++)
		{
			$appname = $apps[$i];

			$opacity = 1 / count($apps);
			$opacity = $opacity + ($opacity * $i);

			$dataDevPerApp .= '{data : ['.$statsApp[$appname].'],';
			$dataDevPerApp .= 'fillColor : "rgba(151,187,205,'.$opacity.')",';
			$dataDevPerApp .= 'title : "'.$appname.'"},';
		}
	// Devices per App

?>

<p id="chart"></p>

<script src='js/chart/ChartNew.js'></script>

<script>

	function setColor(area,data,config,i,j,animPct,value)
	{
	  if(value > 35)return("rgba(220,0,0,"+animPct);
	  else return("rgba(0,220,0,"+animPct);
	  
	}

	var charJSPersonnalDefaultOptions = { decimalSeparator : "," , thousandSeparator : ".", roundNumber : "none", graphTitleFontSize: 2 };

	defCanvasWidth=document.getElementById("chart").offsetWidth;	
	defCanvasHeight=300;


	var mydataDevPerApp = { 
		 labels : [""], 
		 datasets : [<?php echo $dataDevPerApp; ?>] 
	};


	var startWithDataset =1;
	var startWithData =1;


	var optDevPerApp = {
		  animationStartWithDataset : startWithDataset,
		  animationStartWithData : startWithData,
		  animateRotate : true,
		  animateScale : false,
		  animationByData : true,
		  animationSteps : 30,
		  canvasBorders : false,
		  canvasBordersWidth : 3,
		  canvasBordersColor : "black",
		  graphTitle : "Devices per App",
		  legend : true,
		  inGraphDataShow : false,
		  animationEasing: "linear",
		  annotateDisplay : true,
		  spaceBetweenBar : 5,
		  graphTitleFontSize: 18
	}
   
    document.write("<canvas id=\"canvas_DevPerApp\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");

	window.onload = function()
	{
    	var myDoughnut = new Chart(document.getElementById("canvas_DevPerApp").getContext("2d")).Doughnut(mydataDevPerApp,optDevPerApp);
	}

</script>

