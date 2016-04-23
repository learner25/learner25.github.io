
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>planter-editor</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			body {
				font-family: Monospace;
				background-color: #f0f0f0;
				margin: 0px;
				overflow: hidden;
			}

			#oldie { background-color: #ddd !important }
		</style>
		 
	</head>
	<body>

		<script src="build/three.min.js"></script>
		
		
		<script src="js/Detector.js"></script>
		<script src="js/controls/OrbitControls.js"></script>
		
		<script src="js/libs/stats.min.js"></script>
		<script src="base.js"></script>
     
       <div id="add" style="position:absolute;top:56px;left:5px;z-index:9999;display:none;"onclick="clean();">clear</div>
	    <!--<div id="del" style="position:absolute;top:76px;left:5px;z-index:9999;display:block;" onclick="delmode =true;addmode = false;">long click to delete (for smart phone long tap)</div>-->
	    <div id="counter" style="position:absolute;top:86px;right:15px;z-index:9999;display:none;font-size:25px">0</div>
		<div id="save" style="position:absolute;top:102px;right:15px;z-index:9999;display:none;font-size:25px"><a href="javascript:saveJSON();">save</a></div>
		<div id="price" style="position:absolute;top:132px;right:15px;z-index:9999;display:none;font-size:25px">$0</div>
		<input type="hidden" id="hidden" />
	</body>
	<footer>
	 <script>
	       renderer.setClearColor(0xffffff);
	       line.material.opacity = .6;
	       rollOverMesh.material.opacity = .8;
			  system();
	  </script>
	</footer>
</html>
