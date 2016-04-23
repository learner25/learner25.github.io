<html>
<head>


<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><script type="text/javascript" src="three.min.js"></script><script type="text/javascript" src="js/controls/FirstPersonControls.js"></script><script type="text/javascript" src="js/renderers/WebGLRenderer3.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
<title>RoseHill-walk Through</title>

<script>
 var scene,camera,renderer,material,mesh,clock,controls,keyboard,cube,holder,flag=false,effect,count=0,container, planeMesh,body,cube2,geo2,width=7,cube3,test,effect;
 var startime,quaternion ;
 var origin,direction,near,far;
 origin = new THREE.Vector3();
 direction = new THREE.Vector3();
 var file_nomias = 'picci.js';
  var frame,content;
  var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
			var mouseX,mouseY;
			function onload()
			
			{
			    container = document.createElement('div');
    document.body.appendChild(container);
 camera = new THREE.PerspectiveCamera(30, window.innerWidth / window.innerHeight, 1, 100000);
    //camera = new THREE.PerspectiveCamera( 50, 1, 1, 5000 );
camera.position.set(-23.59680684804597,7.24059411231645,-1.6167671172320244);

camera.rotation.set(-0.19,1.315665912040044,0.18809844104436);

//camera.updateProjectionMatrix();
   
   

    scene = new THREE.Scene();
	clock = new THREE.Clock();
	controls = new THREE.FirstPersonControls(camera);
	
				controls.movementSpeed = 46.007;
                 controls.lookSpeed = .05930;
				controls.activeLook = true;
     var holder = new THREE.Object3D();
	 holder.position.set(0,0,0);
	
  
    
   /* var groundMaterial = new THREE.MeshPhongMaterial({
        color: 0x0e0e0e,map:new THREE.ImageUtils.loadTexture('Google_Earth_Snapshot_1.jpg')
    });
    plane = new THREE.Mesh(new THREE.PlaneGeometry(922,825), groundMaterial);
    plane.rotation.x = -Math.PI / 2;
    plane.receiveShadow = true;
	plane.dynamic = true;
    plane.scale.set(.5,.5,.5);
    holder.add(plane);
     plane.position.set(0,4.5,0);*/
    // LIGHTS
    scene.add(new THREE.AmbientLight(0x666666));

    var light;

    light = new THREE.DirectionalLight(0xeeeeee, 1.75);
    light.position.set(300, 400, 50);
    

    light.castShadow = true;
   // light.shadowCameraVisible = true;

    light.shadowMapWidth = 1024;
    light.shadowMapHeight = 1024;

    

    light.shadowCameraLeft = -200;
    light.shadowCameraRight = 200;
    light.shadowCameraTop = 300;
    light.shadowCameraBottom =-400;

    light.shadowCameraFar = 1000;
    light.shadowDarkness = 2.9;

    scene.add(light);
    
   
 /*var fixer = new THREE.CubeGeometry(13,7,21);
   var fix_mesh = new THREE.Mesh(fixer,new THREE.MeshBasicMaterial({map:new THREE.ImageUtils.loadTexture('fix-1.JPG'),opacity:.592,transparent:true,combine:THREE.MixOperation}));
   fix_mesh.position.set(18.44,1.52,218.79);
  fix_mesh.scale.set(.5,1,.5);
   scene.add(fix_mesh);
   
    var fixer2 = new THREE.CubeGeometry(13,7,21);
   var fix_mesh2 = new THREE.Mesh(fixer,new THREE.MeshBasicMaterial({map:new THREE.ImageUtils.loadTexture('fix-1.JPG'),opacity:.592,transparent:true,combine:THREE.MixOperation}));
   fix_mesh2.position.set(-129.68,2.75,-168.58);
  fix_mesh2.scale.set(.5,1,.5);
   scene.add(fix_mesh2);*/
	
	var loader2 = new THREE.JSONLoader();
	loader2.load(file_nomias,function(geometry,material){
	  mesh= new THREE.Mesh( geometry, new THREE.MeshFaceMaterial(material));
      mesh.scale.set( 32.75,32.75,32.75 );
      mesh.position.set(0,0,0);
	  //mesh.rotation.set(0,-Math.PI/6,0);
	  //scene.add(mesh);
	 holder.add(mesh);
	 // controls.target.set(120,-4,-388);
	   //controls.target = holder.position;
	// console.log(controls.radius);
//vector = new THREE.Vector3( mesh.position.x, mesh.position.y, mesh.position.z );
//mesh.position.applyQuaternion( quaternion );
mesh.castShadow = true;		
mesh.recieveShadow = true;

	 get_id = document.getElementById('description');
	 copy = document.getElementById('copy');
	//get_id.innerHTML = 'x: '+ camera.position.x+ '<br>' + 'y: '+ camera.position.y + '<br>'+'z: '+ camera.position.z+ '<br>'+'x-rot: '+camera.rotation.x+ '<br>'+'y-rot: '+camera.rotation.y+ '<br>'+'z-rot: '+camera.rotation.z+'<br><br>'+'<a target="_blank" id="copy" style="z-index:999999"href="http://google.com">click to copy</a>';
		frame = document.getElementById('remove');
	copy.addEventListener('mousedown',MouseDown,false);
	  function MouseDown(e)
	   {
	     switch(e.button)
		   {
		     case 0:
			//window.prompt("Copy to clipboard: Ctrl+C, Enter", get_id.innerText);
			 e.preventDefault();
			 e.stopPropagation();
			frame.innerHTML="";
			 
			 break;
			 default:
			  controls.movementSpeed = 60.007;
		      break;
		   }
	   }
	
//frame = document.getElementById('frame');
       window.setInterval(function(){
	    if(!controls.freeze){
		var c=0;
		c++;
		content = document.createElement('div');
		content.setAttribute("id","bomb-data-"+c);
		var status = frame.scrollHeight - frame.clientHeight <= frame.scrollTop + 1;
	    content.innerHTML ='x: '+ camera.position.x + '<br> y: '+ camera.position.y + '<br>'+'z: '+ camera.position.z+ '<br>'+'x-rot: '+camera.rotation.x+ '<br>'+'y-rot: '+camera.rotation.y+ '<br>'+'z-rot: '+camera.rotation.z+'<br><br>---------------------------------------<br><br><br><br>';
	     frame.appendChild(content);
		 if(status)
	    frame.scrollTop = frame.scrollHeight - frame.clientHeight;
    }
	},500);
 animate();
 //console.log(mesh);
  });
	

    // RENDERER
    webglRenderer = new THREE.WebGLRenderer();
    webglRenderer.setSize(window.innerWidth, window.innerHeight);
    webglRenderer.domElement.style.position = "relative";
    webglRenderer.shadowMapEnabled = true;
    webglRenderer.shadowMapSoft = false;

    container.appendChild(webglRenderer.domElement);
    window.addEventListener('resize', onWindowResize, false);
	//animate();
	
	
	scene.add(holder);
         function setupgui()
          {
             effector={scale:40} ;
             var gui  = new dat.GUI();
             var element = gui.add(effector,'scale',1,40);
             
           }
}
function onWindowResize() {
    windowHalfX = window.innerWidth / 2;
    windowHalfY = window.innerHeight / 2;
 
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    webglRenderer.setSize(window.innerWidth, window.innerHeight);
}

function animate() {
     
    var timer = Date.now() * 0.0002;
    //camera.position.x = Math.cos(timer) * 1000;
    //camera.position.z = Math.sin(timer) * 1000;
	controls.update(clock.getDelta());
	if(camera.position.y<=mesh.position.y+7.00)
	   {
	   var step=0;
	   while(step<=7)
	   {
	   camera.position.y = mesh.position.y+step;
	    step++;
		}
	   }
	  
	  if(!controls.freeze && Math.floor(clock.getElapsedTime())%5==0){
		content = document.createElement('div');
	    content.innerHTML ='x: '+ camera.position.x + '<br> y: '+ camera.position.y + '<br>'+'z: '+ camera.position.z+ '<br>'+'x-rot: '+camera.rotation.x+ '<br>'+'y-rot: '+camera.rotation.y+ '<br>'+'z-rot: '+camera.rotation.z+'<br><br>---------------------------------------<br><br><br><br>';
	   frame.appendChild(content);
    }
	
    
	//mesh.rotation.y+=.03;
	
	var get_id = document.getElementById('description');
	get_id.innerHTML = 'x: '+ camera.position.x+ '<br>' + 'y: '+ camera.position.y + '<br>'+'z: '+ camera.position.z+ '<br>'+'x-rot: '+camera.rotation.x+ '<br>'+'y-rot: '+camera.rotation.y+ '<br>'+'z-rot: '+camera.rotation.z+'<br><br>';
	
    
    requestAnimationFrame(animate);
    render();
}

function render() {
        
	     
        webglRenderer.render(scene, camera);
}


</script>
</head>
<body onload="onload();">
<div id="container" style="width:95%;height:95%;position:absolute;"></div>

<div id="axes" style="position:absolute;top:1%;left:1%;background:rgba(0,0,0,.5);z-index:1;padding:2%;width:200px">
<h6 id="description" style="color:white;font-family:arial"></h6>
</div>

<p><a href="#" id="copy" style="text-decoration: none;position: absolute;bottom: 10;z-index: 9999999;right: 30;font-size: 21px;font-family: arial;background: whitesmoke;padding: 6px;border-radius: 30px;color: rgb(93, 142, 230);">clear</a></p>

<div id="frame" style="width:16%;height:100%;overflow:hidden;position:absolute;z-index:99999;color:white;background:rgba(0,0,0,.5);padding:1%;right:0;font-size:11px">
<div id="remove" style="height:100%;overflow:auto;position:relative;z-index:99999;color:white;background:rgba(0,0,0,0);padding:1%;right:0;font-size:11px"></div>
</div>
</body>
</html>