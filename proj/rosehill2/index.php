<html>
<head>

<script type="text/javascript" src="three.min.js"></script>
		<script type="text/javascript" src="js/controls/RoseHillControls.js"></script>
		<script type="text/javascript" src="js/controls/TransformControls.js"></script>
		
	<script type="text/javascript" src="js/renderers/WebGLRenderer3.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
	<script type="text/javascript" src="js/renderers/CSS3DRenderer.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
	 <script type="text/javascript" src="jquery.zclip.js"></script>
	 <script type="text/javascript" src="ThreeFab.js"></script>
	 <script type="text/javascript" src="DragDropLoader.js"></script>
	
  

<script>
 var scene,camera,renderer,material,mesh,mesh2,clock,controls,controls2,keyboard,cube,holder,flag=false,effect,count=0,container, planeMesh,body,cube2,geo2,width=7,cube3,test,effect;
 var startime,quaternion,niceme ;
 var origin,direction,near,far;
  var file_nomias='picci.js';

 origin = new THREE.Vector3();
 direction = new THREE.Vector3();
 var scale = 1000;
 var get_id,c=0;
 var frame,content;
  var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
			var mouseX,mouseY;
			function onload()
			
			{
			
			    container = document.createElement('div');
    document.body.appendChild(container);
 camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight,1,10000);
    //camera = new THREE.PerspectiveCamera( 50, 1, 1, 5000 );
camera.position.set(0,0,0);
camera.rotation.set(-0.09756442421174907,0.8055137559555768,0.04408746385394859);

//camera.updateProjectionMatrix();
  
  
	    effect = {posX:-3,posY:0,posZ:65,scaX:32.75,scaY:32.75,scaZ:32.75};
		var gui = new dat.GUI();
		 gui.add(effect,'posX',-228,3);
		 gui.add(effect,'posY',0,50);
		 gui.add(effect,'posZ',65,1000);
		  gui.add(effect,'scaX',0,100);
		   gui.add(effect,'scaY',32.75,100);
		    gui.add(effect,'scaZ',32.75,100);

    
    scene = new THREE.Scene();
	clock = new THREE.Clock();
	controls = new THREE.FirstPersonControls(camera,container.canvas);
	
				controls.movementSpeed = 60.007;
                 controls.lookSpeed = .09930;
				controls.activeLook = true;
     var holder = new THREE.Object3D();
	 holder.position.set(0,0,0);
	
  
    
  /*  var groundMaterial = new THREE.MeshPhongMaterial({
        color: 0x0e0e0e,map:new THREE.ImageUtils.loadTexture('Google_Earth_Snapshot_1.jpg')
    });
    plane = new THREE.Mesh(new THREE.PlaneGeometry(922,825), groundMaterial);
    plane.rotation.x = -Math.PI / 2;
    plane.receiveShadow = true;
	plane.dynamic = true;
    plane.scale.set(.5,.5,.5);
    //holder.add(plane);
	*/
     //plane.position.set(0,4.5,0);
    // LIGHTS
    scene.add(new THREE.AmbientLight(0xFFFFFF));

    var light;

   light = new THREE.DirectionalLight(0xFFFfff, .75);
    light.position.set(10, 200, 50);
    

    //light.castShadow = true;
   // light.shadowCameraVisible = true;

   /* light.shadowMapWidth = 1024;
    light.shadowMapHeight = 1024;
    
    

    light.shadowCameraLeft = -200;
    light.shadowCameraRight = 200;
    light.shadowCameraTop = 300;
    light.shadowCameraBottom =-400;

    light.shadowCameraFar = 1000;
    light.shadowDarkness = 2.9;*/
    //scene.fog = new THREE.FogExp2( 0xefd1b5, 0.0125 );
    scene.add(light);
    
   var fixer = new THREE.CubeGeometry(13,7,21);
   var fix_mesh = new THREE.Mesh(fixer,new THREE.MeshBasicMaterial({map:new THREE.ImageUtils.loadTexture('fix-1.JPG'),opacity:1.92,transparent:true,combine:THREE.MixOperation}));
   fix_mesh.position.set(18.44,1.52,218.79);
  fix_mesh.scale.set(.5,1,.5);
  // scene.add(fix_mesh);
   
    var fixer2 = new THREE.CubeGeometry(13,7,21);
   var fix_mesh2 = new THREE.Mesh(fixer,new THREE.MeshBasicMaterial({map:new THREE.ImageUtils.loadTexture('fix-1.JPG'),opacity:.92,transparent:true,combine:THREE.AddOperation}));
   fix_mesh2.position.set(-129.68,2.75,-168.58);
  fix_mesh2.scale.set(.5,1,.5);
  // scene.add(fix_mesh2);
    webglRenderer = new THREE.WebGLRenderer({antialias:true,stencil:false});
    webglRenderer.setSize(window.innerWidth, window.innerHeight);
    webglRenderer.domElement.style.position = "relative";
    webglRenderer.shadowMapEnabled = true;
    webglRenderer.shadowMapSoft = false;
    webglRenderer.physicallyBasedShading
    container.appendChild(webglRenderer.domElement);
    window.addEventListener('resize', onWindowResize, false);
	
	 get_id = document.getElementById('description');
	 copy = document.getElementById('copy');
	//get_id.innerHTML = 'x: '+ camera.position.x+ '<br>' + 'y: '+ camera.position.y + '<br>'+'z: '+ camera.position.z+ '<br>'+'x-rot: '+camera.rotation.x+ '<br>'+'y-rot: '+camera.rotation.y+ '<br>'+'z-rot: '+camera.rotation.z+'<br><br>'+'<a target="_blank" id="copy" style="z-index:999999"href="http://google.com">click to copy</a>';
	//alert(niceme);
	frame = document.getElementById('remove');
	copy.addEventListener('mousedown',MouseDown,false);
	  function MouseDown(e)
	   {
	     switch(e.button)
		   {
		     case 0:
			//window.prompt("Copy to clipboard: Ctrl+C, Enter", get_id.innerText);
			// e.preventDefault();
			// e.stopPropagation();
			
			 frame.innerHTML="";
			 break;
			 default:
			  controls.movementSpeed = 60.007;
		      break;
		   }
	   }
		
	    
		 window.setInterval(function(){
	    if(!controls.freeze){
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
		
	var loader2 = new THREE.JSONLoader();
	loader2.load( 'rosein.js',function(geometry,material){
     	
	  mesh= new THREE.Mesh( geometry, new THREE.MeshFaceMaterial(material));
	  
	
      mesh.scale.set( 32.75,32.75,32.75 );
      mesh.position.set(0,0,0);
	  //mesh.rotation.set(0,-Math.PI/6,0);
	  scene.add(mesh);
	// holder.add(mesh);
	 // controls.target.set(120,-4,-388);
	   //controls.target = holder.position;
	// console.log(controls.radius);
//vector = new THREE.Vector3( mesh.position.x, mesh.position.y, mesh.position.z );
//mesh.position.applyQuaternion( quaternion );
mesh.castShadow = true;		
mesh.recieveShadow = true;
 
// console.log(niceme);
 //console.log(mesh);
 
animate();
  });
  
  var loader3 = new THREE.JSONLoader();
	loader3.load( 'stand.js',function(geometry,material){
     	
	  mesh2= new THREE.Mesh( geometry, new THREE.MeshFaceMaterial(material));
	  material.opacity = .43;
	  material.transparent = true;
	
      mesh2.scale.set( 32.75,32.75,32.75 );
      mesh2.position.set(0.00,0.00,0.00);
	  //mesh.rotation.set(0,-Math.PI/6,0);
	  scene.add(mesh2);
	// holder.add(mesh);
	 // controls.target.set(120,-4,-388);
	   //controls.target = holder.position;
	// console.log(controls.radius);
//vector = new THREE.Vector3( mesh.position.x, mesh.position.y, mesh.position.z );
//mesh.position.applyQuaternion( quaternion );
mesh2.castShadow = true;		
mesh2.recieveShadow = true;
 mesh2.position.set(mesh.position.normalize());
  mesh2.scale.set(mesh.scale.normalize());
// console.log(niceme);
 //console.log(mesh);
 
//animate();
  });
  
  
  controls2 = new THREE.TransformControls(camera,webglRenderer.domElement);
	controls2.attach(mesh);
	
	 controls2.setSize(controls2.size*100);
	 webglRenderer.setClearColor(0x000000,0);
     scene.add(controls2);
	//scene.add(holder);
	
	
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
	//controls2.update();
	//controls2.update();
	if(camera.position.y<=mesh.position.y+7.00)
	   {
	   var step=0;
	   while(step<=7)
	   {
	   camera.position.y = mesh.position.y+step;
	    step++;
		}
	   }
	  
	//mesh.rotation.y+=.03;
	
    //console.log(Math.floor(clock.getElapsedTime())%5);
	//get_id.innerHTML = 'x: '+ camera.position.x+ '<br>' + 'y: '+ camera.position.y + '<br>'+'z: '+ camera.position.z+ '<br>'+'x-rot: '+camera.rotation.x+ '<br>'+'y-rot: '+camera.rotation.y+ '<br>'+'z-rot: '+camera.rotation.z+'<br><br>';
	
  
   //file_nomias = document.getElementById('grp').value;
  
  
     mesh2.position.x = effect.posX;
	 mesh2.position.y = effect.posY;
	 mesh2.position.z = effect.posZ;
	 mesh2.scale.x = effect.scaX;
	 mesh2.scale.y = effect.scaY;
	 mesh2.scale.z = effect.scaZ;
	requestAnimationFrame(animate);
    render();
}


 // document.addEventListener('mousedown',scaler,false);
// function scaler(event)
// {
 // switch(event.button)
 // {
   // case 1 :
 // if( mesh.scale.x>=0 && mesh.scale.y>=0 && mesh.scale.z>=0)
   // {mesh.scale.x-=3.9;
    // mesh.scale.y-=3.9;
	 // mesh.scale.z-=3.9;}
	 // console.log(mesh.scale);
   // break;
 // }
 

// }
function render() {
        
	    // controls2.update();
		
        webglRenderer.render(scene, camera);
}


</script>

</head>
<body onload="onload();">
 <div id="container" style="width:100%;height:100%;position:absolute;">

  </div>
  <!--<div id="axes" style="position:absolute;top:1%;left:1%;background:rgba(0,0,0,.5);z-index:1;padding:2%;width:200px;">
  <h6  id="description" style="color:white;font-family:arial;z-index:99999"></h6>
 
  </div>-->
  <a id="copy" href="#" style="text-decoration: none;position: absolute;bottom: 10;z-index: 9999999;right: 30;font-size: 21px;font-family: arial;background: whitesmoke;padding: 6px;border-radius: 30px;color: rgb(93, 142, 230);">clear</a>
  <div id="frame" style="width:16%;height:100%;overflow:hidden;position:absolute;z-index:99999;color:white;background:rgba(0,0,0,.5);padding:1%;left:0;font-size:11px">
     <div id="remove" style="height:100%;overflow:auto;position:relative;z-index:99999;color:white;background:rgba(0,0,0,0);padding:1%;right:0;font-size:11px"></div>    
	</div>
 


</body>
</html>